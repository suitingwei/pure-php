<?php

namespace Kernel\Application;

use Kernel\Helpers\Traits\Singleton;

class Container
{
    use Singleton;

    private $config = [];

    /**
     * 框架的根目录,Kernel
     * @var string
     */
    private $rootPath;

    /**
     * 整个项目的根目录
     * @var string
     */
    private $basePath;

    /**
     * 用户的目录
     * @var string
     */
    private $appPath;

    public function __construct()
    {
        $this->registerPaths();
        $this->loadConfigure();
        $this->loadHelpers();
    }

    /**
     * 加载配置
     */
    private function loadConfigure()
    {
    }


    public function run()
    {
    }

    /**
     * 注册路径。为了以后加载目录的东西
     */
    private function registerPaths()
    {
        $this->rootPath = realpath(__DIR__.'/../');
        $this->appPath  = __DIR__ . DIRECTORY_SEPARATOR . 'app';
    }

    public function appPath()
    {
        return $this->appPath;
    }

    private function loadHelpers()
    {
        require_once  $this->rootPath.DIRECTORY_SEPARATOR.'Helpers'.DIRECTORY_SEPARATOR.'Functions'.DIRECTORY_SEPARATOR.'helpers.php';
    }

    public function rootPath()
    {
       return $this->rootPath;
    }


}
