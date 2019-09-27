<?php 
namespace app\utils;

use app\utils\WEStringBuilder;

class WEUrlBuilder extends WEStringBuilder {
    
    const DEFAULT_PREFIX = 'http';

    public function __construct($url, $prefix = false) {
        if(!$prefix) {
            parent::__construct($url);
        } else {
            if($prefix === true) {
                $builder = new self(self::DEFAULT_PREFIX);
            } else { 
                $builder = new self($prefix);
            }
            parent::__construct($builder->append('://')->append($url)->toString());
        }
    }

    public function appendGetParams($params) {
        $this->append('?')->append(http_build_query($params));
        return $this;
    }

    public function parseUrl($component = -1) {
        return parse_url($this->value, $component);
    }

    public function getHost() {
        return $this->parseUrl(PHP_URL_HOST);
    }

    public function getScheme() {
        return $this->parseUrl(PHP_URL_SCHEME);
    }

    public function getPort() {
        return $this->parseUrl(PHP_URL_PORT);
    }

    public function getPath() {
        return $this->parseUrl(PHP_URL_PATH);
    }

    public function getQuery() {
        return $this->parseUrl(PHP_URL_QUERY);
    }

    public function getFragment() {
        return $this->parseUrl(PHP_URL_FRAGMENT);
    }

    public function getUser() {
        return $this->parseUrl(PHP_URL_USER);
    }

    public function getPass() {
        return $this->parseUrl(PHP_URL_PASS);
    }
}