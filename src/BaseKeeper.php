<?php

namespace Kackcode\Datasharekeeper;

use GuzzleHttp\Client;

class BaseKeeper {

    protected $apiKey;
    protected $apiUrl;
    protected $httpClient;

    protected function __construct($apiKey,$apiUrl)
    {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
        $this->httpClient = new Client();
    }
}