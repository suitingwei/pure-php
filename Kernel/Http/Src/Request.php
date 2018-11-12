<?php

namespace Kernel\Http\Src;


use Kernel\Helpers\Traits\Singleton;

class Request
{
    use Singleton;

    private $serverData = [];

    /**
     * Get 请求参数
     * @var array
     */
    private $getParameters;

    private  function __construct()
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

    /**
     * 获取 HttpQueryString
     * @return string
     */
    public function getQueryString()
    {
        return $this->serverData['QUERY_STRING'];
    }

    /**
     * @return array
     */
    public function getQueryData()
    {
        parse_str($this->getQueryString(), $this->getParameters);

        return $this->getParameters;
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