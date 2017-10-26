<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2017/10/26
 * Time: 15:35
 */

namespace Kernel\FileSystem\Src;


class DotEnv
{
    private static $instance = null;
    private $fileData = [];
    private $filePath = '';

    public function __construct($path = '')
    {
        $this->filePath = realpath($path ?: './.env');

        $this->readFile();
    }

    protected function getEnv($key, $default = null)
    {
        return isset($this->fileData[$key]) ? $this->fileData[$key] : $default;
    }

    public function readFile()
    {
        $autoDetectLineEncodings = ini_get('auto_detect_line_endings');

        ini_set('auto_detect_line_endings', true);

        $lines = file($this->filePath, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

        foreach ($lines as $line) {
            if ($this->isCommentted($line)) {
                continue;
            }

            list($key, $value) = $this->normalizeLine($line);
            list($key, $value) = $this->normalizeKeyValues($key, $value);
            $this->fileData[$key] = $value;
        }

        ini_set('auto_detect_line_endings', $autoDetectLineEncodings);
    }

    protected function normalizeLine($line)
    {
        return array_map('trim', explode('=', $line, 2));
    }

    /**
     * @param $key
     * @param $value
     * @return array
     */
    protected function normalizeKeyValues($key, $value)
    {
        preg_match('/\${(.*)}/', $value, $match);
        if (count($match) === 0) {
            return [$key, $value];
        }

        $variableName = $match[1];
        if (!isset($this->fileData[$variableName])) {
            return [$key, $value];
        }
        return [$key, str_replace($match[0], $this->fileData[$variableName], $value)];
    }

    public static function __callStatic($method, $parameters)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }

        if (!method_exists(self::$instance, $method)) {
            throw new \Exception("{$method} does'nt exist ");
        }

        return self::$instance->{$method}(...$parameters);
    }

    private function isCommentted($line)
    {
        return $line[0] === '#';
    }
}