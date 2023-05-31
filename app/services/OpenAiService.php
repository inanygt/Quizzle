<?php

namespace App\Services;

use GuzzleHttp\Client;

class OpenAIService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function generateQuestion($subject)
    {
        $response = $this->client->request('POST', 'https://api.openai.com/v1/engines/davinci-codex/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_KEY'),
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'prompt' => "Generate a multiple-choice question about {$subject}",
                'max_tokens' => 200
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
