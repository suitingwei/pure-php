<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2018/9/12
 * Time: 20:15
 */

use InfluxDB\Database;
use InfluxDB\Point;

require __DIR__ . '/../vendor/autoload.php';


$host   = '127.0.0.1';
$port   = '8086';
$client = new InfluxDB\Client($host, $port);


$shell     = 'grep "2018-08-15T05" ./studentNginxAccess2018081505.log | awk -F \'[ ?]\' \'{print $6 "\t" $10 "\t" $12 "\t" $13"\t\n" }\'';
$shellData = explode("\n",shell_exec($shell));



// fetch the database
$database = $client->selectDB('sui');

// executing a query will yield a resultset object
try {
    
    $points = [];
    foreach ($shellData as $logLine) {
        if(empty($logLine)){
            continue;
        }
        echo "logging...$logLine\n";
        $logLine = explode("\t",$logLine);
        $points[] = new Point(
            'nginxAccessLog',
            null,
            [
                'status' => $logLine[1],
                'url'    => $logLine[3]
            ],
            //fields are required
            ['method'=>$logLine[2]],
            //utf time format
            strtotime($logLine[0])
        );
    }
    

    $result = $database->writePoints($points, Database::PRECISION_SECONDS);
} catch (Exception $e) {
    
    echo $e->getMessage(); die();
}

