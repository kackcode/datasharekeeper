<?php

namespace Kackcode\Datasharekeeper;

use Kackcode\Datasharekeeper\BaseKeeper;
use GuzzleHttp\Exception\RequestException;

class EmailSaver extends BaseKeeper {


    public function saveItNow($endpoint, $data)
    {
        try {
            $response = $this->httpClient->post($this->apiUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-API-KEY' => $this->apiKey,
                ],
                'json' => $data,
            ]);

            $statusCode = $response->getStatusCode();
            $contentBody = $response->getBody()->getContents();
            if ($statusCode === 200) {
                return [
                    'status' => true,
                    'message' => 'Email save successfully!',
                    'data' => $contentBody
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Failed to save email. Status code: ' . $statusCode,
                    'data' => $contentBody
                ];
            }
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return [
                'status' => false,
                'message' => 'Error sending request: ' . $e->getMessage()
            ];
        }
    }
}