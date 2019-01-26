<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/1/26
 * Time: 15:21
 */

use InfluxDB\Database;
use InfluxDB\Point;

require __DIR__ . '/../vendor/autoload.php';

/**
 * A class used to sync log files into the influx db.
 * Class Syncer
 */
class Syncer
{
    private $host;

    /**
     * @var
     */
    private $port;

    /**
     * The client to the influx db.
     * @var \InfluxDB\Client
     */
    private static $influxDBClient;

    private $srcFile;

    /**
     * The influx database which the sync data should be written into.
     * @var string
     */
    private $database;

    /**
     * The influx measurement which the sync data should be written into.
     * @var string
     */
    private $measurement;

    public function __construct($host = 'localhost', $port = 8086)
    {
        if (is_null(static::$influxDBClient)) {
            return static::$influxDBClient = new InfluxDB\Client($this->host = $host, $this->port = $port);
        }
        return static::$influxDBClient;
    }

    public function sync()
    {
        // create an array of points
        try {
            $points = [
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
                ),
            ];
            // we are writing unix timestamps, which have a second precision
            $result = $this->influxDBClient->writePoints($points, Database::PRECISION_SECONDS);
        } catch (\InfluxDB\Database\Exception $e) {
        } catch (\InfluxDB\Exception $e) {
        }
    }

    /**
     * Set the src file to sync data.
     * @param string $srcFile
     * @return $this
     * @throws Exception
     */
    public function fromFile(string $srcFile)
    {
        if (!file_exists($srcFile)) {
            throw new \Exception("File: {$srcFile} not found!");
        }
        $this->srcFile = $srcFile;
        return $this;
    }

    /**
     * Choose the database which the data should be sync into.
     * @param string $database
     * @return Syncer
     */
    public function useDB(string $database)
    {
        $this->database = $database;
        return $this;
    }

    /**
     * @param string $measurement
     * @return $this
     */
    public function toMeasurement(string $measurement)
    {
        $this->measurement = $measurement;
        return $this;
    }

    public function shell(string $shellCommand, callable $callback)
    {
        $shellCommand = str_replace('[FILE_NAME]',$this->srcFile,$shellCommand);

        $data = shell_exec($shellCommand);

        foreach ($data as $line) {
            call_user_func($callback, ...$line);
        }
    }
}

try {
    $syncer = new Syncer();
    /**
     * Nginx Log Format
     *
     * 2019-01-26T15:49:00+08:00 - 0.233 - 200 - GET /wp-json/wp/v2/categories?per_page=100&orderby=name&order=asc&_fields=id%2Cname%2Cparent&_locale=user HTTP/1.1 - http://39.105.1.40/wp-admin/post.php?post=892&action=edit - [961] - unix:/var/run/php/php7.2-fpm.sock - 0.236 - 47.75.197.179
     *
     */
    $syncer->fromFile('/var/www/html/wordpress/logs/access.log')
        ->useDB('wordpress')
        ->toMeasurement('access-log')
        ->shell(" cat [FILE_NAME]  | awk -F \"[ - ]\" '{printf(\"%s\t%s\t%s\t%s\t%s\n\",$1,$3,$5,$7,$8) }'", function () {

        });
} catch (Exception $e) {
}
