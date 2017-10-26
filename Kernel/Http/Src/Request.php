<?php

namespace Http\Src;

class Request
{
    private $serverData = [];

    public function __construct()
    {
        $this->serverData = $_SERVER;
    }

    public function getServerData()
    {
        return $this->serverData;
    }

    public static function getSAPI()
    {
        return PHP_SAPI;
    }

    public function getIp()
    {
        return $this->serverData['REMOTE_ADDR'];
    }

    public function getUrl()
    {
        return $this->serverData['REQUEST_URI'];
    }

    public function getQueryString()
    {
        return $this->serverData['QUERY_STRING'];
    }

    public function getQueryData()
    {
        $data = [];

        parse_str($this->getQueryString(), $data);

        return $data;
    }

    public function getHeaders()
    {
        $result = [];
        foreach ($this->serverData as $key => $server) {
            if( 0 === strpos($key,'HTTP_')){
                $result[substr($key,5)] = $server;
            }
        }
        return $result;
    }

}