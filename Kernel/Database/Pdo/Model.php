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

    /**
     * @var Configure
     */
    private $configure;

    public function __construct()
    {
        $this->pdo = new \PDO($this->configure->getDsn());
    }

}