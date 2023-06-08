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
    $prompt = "Create a " . $num_questions . "-question multiple choice quiz about " . $subject . ". Each question should start with a '+', followed by 4 answers where the correct answer starts with a '*'. ALWAYS LIKE THIS!!:\n+Example Question 1\n-Answer 1\n-Answer 2\n*Correct Answer 3\n-Answer 4";

    $response = $this->client->request('POST', 'https://api.openai.com/v1/engines/text-davinci-002/completions', [
        'headers' => [
            'Authorization' => 'Bearer ' . env('OPENAI_KEY'),
            'Content-Type' => 'application/json'
        ],
        'json' => [
            'prompt' => $prompt,
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

        $quizData = [];
        $question = '';
        $answers = [];

        foreach ($lines as $line) {
            // Skip empty lines
            if (trim($line) === '') {
                continue;
            }

            // If the line starts with '+', it's a question
            if (substr(trim($line), 0, 1) == '+') {
                // Start a new question
                $question = substr(trim($line), 1);
                $answers = [];
            } else if (substr(trim($line), 0, 1) == '-' || substr(trim($line), 0, 1) == '*') {
                // If the line starts with '-', it's an incorrect answer, '*' indicates the correct answer
                $isCorrect = (substr(trim($line), 0, 1) == '*') ? true : false;
                $answerText = substr(trim($line), 1);
                $answers[] = [
                    'text' => $answerText,
                    'is_correct' => $isCorrect,
                ];
            }

            // If we've got 4 answers, it's the end of current question
            if (count($answers) === 4) {
                // Shuffle the answers to hide the correct one
                shuffle($answers);

                $quizData[] = [
                    'question' => $question,
                    'answers' => $answers,
                ];
            }
        }

        return $quizData;
    }
}
