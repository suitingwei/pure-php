<?php

use Kernel\Database\Pdo\Model;

require './vendor/autoload.php';

require './helpers.php';

$data = require __DIR__ . '/Kernel/Config/database.php';


$orm = new Model();


