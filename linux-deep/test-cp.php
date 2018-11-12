<?php
//first we need to create a large file, such as 1GB?
createLargeFile(1014, './file1');

//second,we should copy the first file into the second file, and collect the stats during the copy method.
copyFile('./file1', './file2');


/**
 * Create the file.
 */
function createLargeFile($mbSize=1024, $fileName)
{
    if (is_file($fileName)) {
        return $fileName;
    }
    
    //create a one mb string,and write it into the file.
    $oneMbStr = createKbStr(1024);
    
    for ($i = 0; $i < $mbSize; $i++) {
        file_put_contents($fileName, $oneMbStr, FILE_APPEND);
    }
    
    return $fileName;
}

/**
 * @param int $kbSize
 *
 * @return string
 */
function createKbStr($kbSize = 1)
{
    $bytesSize = $kbSize * 1024;
    
    return implode('', array_fill(0, $bytesSize, 'a'));
}

function copyFile($firstFile, $secondFile)
{
    echo "memory usage=" .memory_get_peak_usage(true) .PHP_EOL ;
    copy($firstFile, $secondFile);
    echo "memory usage=" .memory_get_peak_usage(true) .PHP_EOL ;
}
