<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2017/10/26
 * Time: 17:39
 */

namespace Kernel\Database\Pdo;

class Model
{
    private $pdo = null;

    public function __construct()
    {
        $this->pdo = new \PDO($this->getDsnString());
    }

    protected function getDsnString()
    {
        return '';
    }


    protected function getDatabaseHost()
    {

    }
}