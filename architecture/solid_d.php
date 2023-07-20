<?php

interface XMLHTTPRequestService {
    public function request($url, $http, $options = []);
}

class XMLHttpService implements XMLHTTPRequestService {
    public function request($url, $http, $options = []) {
        return $url.$http.!empty($options);
    }
}

class Http {
    private $service;

    public function __construct(XMLHTTPRequestService $xmlHttpRequestService) {
        $this->service = $xmlHttpRequestService;
    }

    public function get(string $url, array $options) {
       return $this->service->request($url, 'GET', $options);
    }

    public function post(string $url) {
       return $this->service->request($url, 'GET');
    }
}
