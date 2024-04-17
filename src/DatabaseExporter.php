<?php

namespace Kackcode\Datasharekeeper;

use Spatie\DbDumper\Databases\MySql;
use Kackcode\Datasharekeeper\BaseKeeper;
use GuzzleHttp\Exception\RequestException;

class DatabaseExporter extends BaseKeeper {


    public function exportAndSendBackup($db_name, $db_username, $db_password, $upload_dir, $filename)
    {
        $filename = $filename.'_backup_' . date('Y-m-d-H-i-s') . '.sql';
        $local_file_path = $upload_dir . $filename;

        // Export the database
        MySql::create()
            ->setDbName($db_name)
            ->setUserName($db_username)
            ->setPassword($db_password)
            ->dumpToFile($local_file_path);

        // Send the backup file to the remote server via POST request

        try {
            // Send POST request with file and X-API-KEY header
            $response = $this->httpClient->post($this->apiUrl, [
                'headers' => [
                    'X-API-KEY' => $this->apiKey,
                ],
                'multipart' => [
                    [
                        'name' => $filename,
                        'contents' => fopen($local_file_path, 'r'),
                        'filename' => $filename,
                    ],
                ],
            ]);

            // Handle response
            $statusCode = $response->getStatusCode();
            $contentBody = $response->getBody()->getContents();

            if ($statusCode === 200) {
                unlink($local_file_path);
                return [
                    'status' => true,
                    'message' => 'Backup sent successfully!',
                    'data' => $contentBody
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Failed to send backup. Status code: ' . $statusCode,
                    'data' => $contentBody
                ];
            }
        } catch (RequestException $e) {
            return [
                'status' => false,
                'message' => 'Error sending request: ' . $e->getMessage()
            ];
        }
    }
}
