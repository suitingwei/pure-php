<?php

if (!function_exists('env')) {
    /**
     * Get the env.
     * @param null $key
     * @param null $default
     * @return mixed|string
     */
    function env($key,$default=null ){
        return \Kernel\FileSystem\Src\DotEnv::getEnv($key,$default);
    }
}

if (!function_exists('appPath')) {
    /**
     * @return mixed|string
     */
    function appPath(){
        return Kernel\Application\Container::getInstance()->appPath();
    }
}

if (!function_exists('rootPath')) {
    /**
     * @return mixed|string
     */
    function rootPath(){
        return Kernel\Application\Container::getInstance()->rootPath();
    }
}
