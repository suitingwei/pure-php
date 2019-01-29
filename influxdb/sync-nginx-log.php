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
    private $influxDBClient;

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
        date_default_timezone_set('PRC');
        return $this->influxDBClient = new InfluxDB\Client($this->host = $host, $this->port = $port);
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

    public function rawSync()
    {
        try {
            $shellCommand = "cat {$this->srcFile}  | awk -F \"[ - ]\" '{printf(\"%s %s %s %s %s\\\\n\",$1,$3,$5,$7,$8) }'";
            $data         = shell_exec($shellCommand);
            $data         = explode('\n', $data);

            $points = [];
            foreach ($data as $line) {
                if (empty($line)){
                    continue;
                }
                $requestData = explode(' ', $line);
                array_push($points,
                    new Point(
                        $this->measurement, // name of the measurement
                        null,
                        [
                            'request_status' => $requestData[2],
                            'request_method' => $requestData[3],
                            'request_uri'    => $requestData[4],
                        ],
                        [
                            'request_time'   => $requestData[1],
                        ],
                        date("U", strtotime($requestData[0]))
                    )
                );
            }
            $this->influxDBClient->selectDB($this->database)->writePoints($points,Database::PRECISION_SECONDS);
        } catch (\InfluxDB\Exception $e) {
            throw new $e;
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
        ->toMeasurement('access_log')
        ->rawSync();

} catch (Exception $e) {
}
