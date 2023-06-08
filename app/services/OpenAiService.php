<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false
        ]);
    }

    public function generateQuestion($subject, int $num_questions)
    {
        $response = $this->client->request('POST', 'https://api.openai.com/v1/engines/text-davinci-002/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_KEY'),
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'prompt' => "make me a multiple choice quiz where each question has 4 answers and 1 correct answer. Create {$num_questions} questions about {$subject}. Each question should have a number, questions need to start with a '+', answers need to start with a '-' and the correct answer should start with a '*'.",
                'max_tokens' => 1000
            ]
        ]);

        $responseArray = json_decode($response->getBody(), true);

        // Log the response from the API
        Log::info('OpenAI API Response', $responseArray);

        $quizData = $this->parseResponse($responseArray);

        return $quizData;
    }

    public function parseResponse($responseArray)
{
    // Extract the text from the response
    $text = $responseArray['choices'][0]['text'];

    // Break the response into individual lines
    $lines = explode("\n", $text);

    $isFirstLine = true;
    $quizData = [];
    $question = '';
    $answers = [];
    $correctAnswer = '';

    foreach ($lines as $line) {
        // Skip empty lines
        if (trim($line) === '') {
            continue;
        }

        // If the line starts with '+', it's a question
        if (substr(trim($line), 0, 1) == '+') {
            if (!$isFirstLine && !empty($question) && !empty($answers)) {
                $quizData[] = [
                    'question' => $question,
                    'answers' => $answers,
                    'correctAnswer' => $correctAnswer,
                ];
            }
            // Start a new question
            $question = substr(trim($line), 1);
            $answers = [];
            $correctAnswer = '';
            $isFirstLine = false;
        } else if (substr(trim($line), 0, 1) == '-' || substr(trim($line), 0, 1) == '*') {
            // If the line starts with '-', it's an incorrect answer, '*' indicates the correct answer
            $isCorrect = (substr(trim($line), 0, 1) == '*') ? true : false;
            $answerText = substr(trim($line), 1);
            $answers[] = [
                'text' => $answerText,
                'is_correct' => $isCorrect,
            ];
            // if the answer is correct, it is the correct answer of the question
            if ($isCorrect) {
                $correctAnswer = $answerText;
            }
        }
    }

    // Add the last question to the array
    if (!empty($question) && !empty($answers)) {
        $quizData[] = [
            'question' => $question,
            'answers' => $answers,
            'correctAnswer' => $correctAnswer,
        ];
    }

    return $quizData;
}

}
