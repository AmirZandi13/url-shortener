<?php

namespace Src\controllers;

use Src\services\UrlService;

class UrlController
{
    private $requestMethod;
    private $urlService;

    public function __construct($requestMethod)
    {
        $this->requestMethod = $requestMethod;
        $this->urlService = new UrlService();
    }

    public function processRequest()
    {
        $method = strtolower($this->requestMethod);

        $response = $this->urlService->{$method}();

        $json_response = json_encode($response);

        http_response_code($response['status_code_header']);
        echo $json_response;
    }
}