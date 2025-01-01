<?php
namespace Kackcode\Datasharekeeper\Geo;

class GeoLocation
{
    public static function getUserCountry(): string
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $response = file_get_contents("http://ip-api.com/json/{$ip}");
        $data = json_decode($response, true);

        return $data['country'] ?? 'Country information not available';
    }
}
