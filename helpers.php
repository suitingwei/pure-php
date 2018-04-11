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





