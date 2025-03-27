<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HeyzineService
{
    protected $clientId;
    protected $client;

    public function __construct()
    {
        $this->clientId = config('services.heyzine.client_id'); // Store client ID in config
        $this->client = new Client(); // No base_uri or auth header needed for this API
    }

    public function uploadfile($pdfUrl)
    {
        try {
            $response = $this->client->post('https://heyzine.com/api1/rest', [
                'json' => [
                    'pdf' => 'https://rjworld10.com',
                    'client_id' => $this->clientId, // Corrected line
                    'prev_next' => true, // Or other parameters as needed
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Add other Heyzine API methods as needed (e.g., get flipbook details, delete flipbook)
}