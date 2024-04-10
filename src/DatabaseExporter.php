<?php

namespace Kackcode\Datasharekeeper;

use Spatie\DbDumper\Databases\MySql;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DatabaseExporter
{
    public static function exportAndSendBackup($db_name, $db_username, $db_password, $upload_dir, $filename, $request_url,$api_key)
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
        $client = new Client();

        try {
            // Send POST request with file and X-API-KEY header
            $response = $client->post($apiUrl, [
                'headers' => [
                    'X-API-KEY' => $api_key,
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
            if ($statusCode === 200) {
                unlink($local_file_path);
                return [
                    'status' => true,
                    'message' => 'Backup sent successfully!',
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Failed to send backup. Status code: ' . $statusCode
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
