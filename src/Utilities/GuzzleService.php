<?php

namespace Kackcode\Datasharekeeper\Utilities;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GuzzleService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function sendJsonPostRequest(string $url, array $data)
    {
        try {
            $response = $this->client->post($url, [
                'json' => $data,
            ]);
            return $response->getStatusCode() === 200;
        } catch (RequestException $e) {
            return false;
        }
    }

    public function sendPostRequestWithHeader(string $url, array $headers,$body)
    {
        try {
            // Send the POST request using Guzzle
            $response = $this->client->post($url, [
                'headers' => $headers,
                'body' => $body,
            ]);

            // Check if the response status is 200 (OK)
            if ($response->getStatusCode() === 200) {
                return true;
            }

            return false;
        } catch (RequestException $e) {
            // Handle errors (e.g., network issues, invalid response)
            return false;
        }
    }
}
