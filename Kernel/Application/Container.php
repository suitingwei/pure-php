<?php

namespace Kernel\Application;

class Container
{
    private $config = [];

    public function __construct()
    {
        $this->loadConfigure();
    }

    /**
     * 加载配置
     */
    private function loadConfigure()
    {
    }
}
