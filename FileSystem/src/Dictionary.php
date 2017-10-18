<?php

namespace FileSystem;

/**
 * Class Directory
 * @package FileSystem
 */
/**
 * Class Directory
 * @package FileSystem
 */
class Directory
{
    private $dirHandle = null;

    private $files = [];

    /**
     * Dictionary constructor.
     * @param $path
     * @throws \Exception
     */
    public function __construct($path)
    {
        $this->dirHandle = opendir($path);
        if (false === $this->dirHandle) {
            throw new \Exception('Open directory failed!');
        }
    }

    public function getDirectoryFiles()
    {
        while (false !== ($file = readdir($this->dirHandle))) {
            if ($file == '.' or $file == '..') {
                continue;
            }
            array_push($this->files, $file);
            echo $file . PHP_EOL;
        }
    }

    public static function getDirectoryFilesRecursive($dirPath, &$result)
    {
        echo 'Current result is   ';
        print_r($result);
        $dirHandle = opendir($dirPath);

        if (false === $dirHandle) {
            return false;
        }

        while (false !== ($file = readdir($dirHandle))) {
            //Skip the useless . .. .xx files.
            if ($file == '.' or $file == '..' or substr($file, 0, 1) == '.') {
                continue;
            }

            $filePath = $dirPath . '/' . $file;
            $arrayKey = substr($dirPath, strrpos($dirPath, '/') + 1);

            if (is_file($filePath)) {
                $result[$arrayKey][] = $file;
            } elseif (is_dir($filePath)) {
                isset($result[$arrayKey]) ? $result[$arrayKey] [] = $file : $result[$arrayKey] = [$file];
                self::getDirectoryFilesRecursive($filePath, $result);
            }
        }
        closedir($dirHandle);
        return $result;
    }

    /**
     * Return the last part of the element split by '/'
     * @param $path
     * @return string
     */
    public function basename($path)
    {
        echo <<<qwe
Function basename return the "file name" of the path string.
In fact, it only takes the last word after the last slash.\n
qwe;
        return basename($path);
    }

    public function getDirName($path)
    {
        echo <<<qwe
--------------------------------------------------------------------------------
Function basename return the "file name" of the path string.
In fact, it only takes the previous before the last word after the last slash.
--------------------------------------------------------------------------------\n
qwe;
        return dirname($path);
    }

    /**
     * @param $source
     * @param $dest
     * @return bool
     */
    public function copy($source, $dest)
    {
        $result = copy($source, $dest);

        if (!$result) {
            return false;
        }
        return true;
    }

    public function delete($path)
    {
        if (!is_file($path)) {
            return false;
        }

        unlink($path);
    }

    public function createFile($path)
    {
        $result = touch(__DIR__ . $path);
        if ($result) {
            return true;
        }
        return false;
    }

    public function getDIRSuperVariable()
    {
        echo __DIR__ . PHP_EOL;
    }

    public function getCurrentDirectory()
    {
        return dirname(__FILE__);
    }

    public function getCurrentFunctionName()
    {
        return __FUNCTION__;
    }

    public function getDirFreeSpace($dirPath)
    {
        return disk_free_space($dirPath);
    }

    public function humanReadableSize($bytes)
    {
        $unit = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $base = 1024;
        $class = min((int)log($bytes, $base), count($unit) - 1);
        return sprintf('%1.2f', $bytes / pow($base, $class)) . ' ' . $unit[$class];
    }

    /**
     *
     * @param $path
     * @return bool
     */
    public function isFile($path)
    {
        return boolval(is_file($path));
    }

    public function readFileByCharacter($path)
    {
        if (!is_file($path)) {
            return false;
        }
        $fileHandle = @fopen($path, 'r');

        while (false !== ($ch = fgetc($fileHandle))) {
            echo $ch . ' ';
        }

        fclose($fileHandle);
        return true;
    }


    /**
     * @param $path
     */
    public function readFileByLine($path)
    {
        if (!is_file($path)) {
            return false;
        }
        $fileHandle = @fopen($path, 'r');

        while (false !== ($ch = fgets($fileHandle))) {
            echo $ch . ' ';
        }

        fclose($fileHandle);
        return true;
    }

    public function getFileContents($path)
    {
       return file_get_contents($path) ;
    }

    public function downloadFile($url)
    {

    }
}
