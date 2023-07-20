<?php

 class Single {
    protected static $_instance;
    private $key;
        private function __construct() {
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    private function __clone() {
    }

    private function __wakeup() {
    }

     /**
      * @return mixed
      */
    public function getSecretKey() {
        return $this->key;
    }

     /**
      * @param mixed $key
      */
     public function setSecretKey($key) {
         $this->key = $key;
     }
}

class Concept {
    private $client;

    public function __construct() {
        $this->client = new \GuzzleHttp\Client();
    }

    public function getUserData() {
        if(!file_get_contents('key.txt')) {
            file_put_contents('key.txt', 'ersfn3sefo1esvoesn42vseo', FILE_APPEND);
        }
        Single::getInstance()->setSecretKey(file_get_contents('key.txt'));
        $params = [
            'auth' => ['user', 'pass'],
            'token' => Single::getInstance()->getSecretKey()
        ];

        $request = new \Request('GET', 'https://api.method', $params);
        $promise = $this->client->sendAsync($request)->then(function ($response) {
            $result = $response->getBody();
        });

        $promise->wait();
    }
}