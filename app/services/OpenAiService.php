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


    public function generateQuestion($subject)
    {
        $response = $this->client->request('POST', 'https://api.openai.com/v1/engines/text-davinci-002/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_KEY'),
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'prompt' => "Generate a multiple-choice question about {$subject}",
                'max_tokens' => 200
            ]
        ]);

        $responseArray = json_decode($response->getBody(), true);

        // Log the response from the API
        Log::info('OpenAI API Response', $responseArray);

        $parsedQuestion = $this->parseResponse($responseArray);

        return $parsedQuestion;
    }


    public function parseResponse($responseArray)
    {
        // Extract the text from the response
        $text = $responseArray['choices'][0]['text'];

        // Split the text into lines
        $lines = explode("\n", $text);

        // The first line is the question
        $question = trim($lines[0]);  // assuming the question is always the first line

        // The next lines are the choices, and we filter out any empty strings in case of blank lines
        $choices = array_filter(array_slice($lines, 1, -1));  // assuming the choices are lines from the second to the second last

        // The last line is the correct answer
        $correctAnswer = trim(end($lines));  // assuming the correct answer is always the last line

        $parsedQuestion = [
            'question' => $question,
            'choices' => $choices,
            'correct_answer' => $correctAnswer
        ];

        return $parsedQuestion;
    }


    // public function parseResponse($responseArray)
    // {
    //     // Extract the text from the response
    //     $text = $responseArray['choices'][0]['text'];

    //     // Split the text into lines
    //     $lines = explode("\n", $text);




    //             // The first line is the question
    //     $question = $lines[0];  // assuming the question is always the first line

    //     // The next lines are the choices, and we filter out any empty strings in case of blank lines
    //     $choices = array_filter(array_slice($lines, 1, -1));  // assuming the choices are lines from the second to the second last



    //     // // The first line is the question
    //     // $question = $lines[1];  // assuming the question is always the second line

    //     // // The next lines are the choices
    //     // $choices = array_slice($lines, 2, -1);  // assuming the choices are always lines 3 to the second last

    //     // The last line is the correct answer
    //     $correctAnswer = end($lines);  // assuming the correct answer is always the last line

    //     $parsedQuestion = [
    //         'question' => $question,
    //         'choices' => $choices,
    //         'correct_answer' => $correctAnswer
    //     ];

    //     return $parsedQuestion;
    // }


    // public function parseResponse($responseArray)
    // {
    //     // Write your parsing logic here. You will need to extract the question,
    //     // choices, and correct answer from the response. How you do this will depend
    //     // on the format of the response you get from the API. The example below assumes
    //     // a specific format.

    //     $parsedQuestion = [
    //         'question' => $responseArray['question'],  // replace with your parsing logic
    //         'choices' => $responseArray['choices'],  // replace with your parsing logic
    //         'correct_answer' => $responseArray['correct_answer']  // replace with your parsing logic
    //     ];

    //     return $parsedQuestion;
    // }

}
