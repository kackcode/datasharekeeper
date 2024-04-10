<?php

namespace Kackcode\Datasharekeeper;

use Illuminate\Support\Facades\Http;
use Spatie\DbDumper\Databases\MySql;

class DatabaseExporter
{
    public static function exportAndSendBackup($db_name, $db_username, $db_password, $upload_dir, $filename, $request_url)
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
        $response = Http::attach(
            'backup',
            file_get_contents($local_file_path),
            $filename
        )->post($request_url);

        // Check if the request was successful
        if ($response->successful()) {
            // Optionally, you can delete the local backup file after sending
            unlink($local_file_path);

            return 'Backup sent successfully!';
        } else {
            return 'Failed to send backup to the remote server.';
        }
    }
}
