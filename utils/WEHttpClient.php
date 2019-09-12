<?php

namespace app\utils;

class WEHttpClient {

    private $ch;

    public function __construct($url) {
        $this->ch = curl_init($url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
    }

    public function __destruct() {
        $this->close();
    }

    private function close() {
        curl_close($this->ch);
    }

    public function addHeader($header) {
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);
    }

    private function execute() {
        return curl_exec($this->ch);
    }

    public function get() {
        return $this->execute();
    }

    public function post($data, $https = true) {
        if($https) {
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        return $this->execute();
    }

    public function getError() {
        return curl_error($this->ch);
    }

    public function getStatusCode() {
        return curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
    }
}