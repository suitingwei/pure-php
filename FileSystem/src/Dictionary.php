<?php

namespace FileSystem;

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

    /**
     * Get the directory's all files.
     * The dot, dot dot will be skipped.
     * @return array
     */
    public function getDirectoryFiles()
    {
        while (false !== ($file = readdir($this->dirHandle))) {
            if ($file == '.' or $file == '..') {
                continue;
            }
            array_push($this->files, $file);
            echo $file . PHP_EOL;
        }
        return $this->files;
    }

    /**
     * Get the directory's all files recursively.
     * @param $dirPath
     * @param $result
     * @return bool
     */
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

    /**
     * Get the dir name, which actually only get the string before the last slash character.
     * For example, /etc/password => /etc,  /usr/share/nginx/html/test.html => /usr/share/nginx/html;
     * @param $path
     * @return string
     */
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
     * Copy the file.
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

    /**
     * Delete the file.
     * @param $path
     * @return bool
     */
    public function delete($path)
    {
        if (!is_file($path)) {
            return false;
        }

        unlink($path);
    }

    /**
     * Create an empty file, and write the content if necessary.
     * @param $path
     * @param string $content
     * @return bool
     */
    public function createFile($path, $content = '')
    {
        $fileHandle = fopen($path, 'a+');
        if (false === $fileHandle) {
            return false;
        }
        fwrite($fileHandle, $content);

        fclose($fileHandle);

        return true;
    }

    /**
     * Get the __DIR__ variable, only for test the behavior in the require/include statement.
     * The __DIR__, __FILE__ will return the actually written file, rather the included place.
     * For example, if the code was written in the B.php, and included in the A.php,
     * the __FILE__ will still return the B.php, and the path of it when called __DIR__.
     * @return string
     */
    public function getDIRSuperVariable()
    {
        echo __DIR__ . PHP_EOL;
    }

    /**
     * Get the code's current directory.
     * @return string
     */
    public function getCurrentDirectory()
    {
        return dirname(__FILE__);
    }

    /**
     * Get the current function name.
     * @return string
     */
    public function getCurrentFunctionName()
    {
        return __FUNCTION__;
    }

    /**
     * Get the directory's free space
     * @param $dirPath
     * @return bool|float
     */
    public function getDirFreeSpace($dirPath)
    {
        return disk_free_space($dirPath);
    }

    /**
     * @param $bytes
     * @return string
     */
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
     * Read the file line by line.
     * @param $path
     * @return bool
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
        return file_get_contents($path);
    }

    /**
     * @param $url
     */
    public function downloadFile($url, $saveFileName)
    {
        file_put_contents($saveFileName, file_get_contents($url));
    }
}
