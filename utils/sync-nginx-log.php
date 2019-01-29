<?php
/**
 * 同步 Nginx log 到 influxdb
 *
 */

use InfluxDB\Point;

require __DIR__ . '/../vendor/autoload.php';

// create an array of points
try {
    $client = new InfluxDB\Client($host, $port);
    $points = array(
        new Point(
            'test_metric', // name of the measurement
            0.64, // the measurement value
            ['host' => 'server01', 'region' => 'us-west'], // optional tags
            ['cpucount' => 10], // optional additional fields
            1435255849 // Time precision has to be set to seconds!
        ),
        new Point(
            'test_metric', // name of the measurement
            0.84, // the measurement value
            ['host' => 'server01', 'region' => 'us-west'], // optional tags
            ['cpucount' => 10], // optional additional fields
            1435255849 // Time precision has to be set to seconds!
        )
    );
    // we are writing unix timestamps, which have a second precision
    $result = $database->writePoints($points, Database::PRECISION_SECONDS);
    
} catch (\InfluxDB\Database\Exception $e) {
} catch (\InfluxDB\Exception $e) {
}

