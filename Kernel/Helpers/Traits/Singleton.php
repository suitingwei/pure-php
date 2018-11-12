<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2018/4/12
 * Time: 10:22
 */

namespace Kernel\Helpers\Traits;

trait Singleton
{
    private static $instance = null;

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            return static::$instance = new static();
        }
        return static::$instance;
    }
}