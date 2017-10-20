<?php
namespace Http\Src;

class Request
{
    public function __construct()
    {


    }

    public function url()
    {

        return $_SERVER;
    }

}