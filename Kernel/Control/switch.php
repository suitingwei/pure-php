<?php

require './Src/Interfaces/FileType.php';
require './Src/Files/VideoFile.php';
require './Src/Files/ImageFile.php';
require './Src/Files/TextFile.php';

use Control\Src\Interfaces\FileType;
use Control\Src\Files\{
    VideoFile, TextFile, ImageFile
};


function useSwitch($file)
{
    switch ($file) {
        case 1 :
            return 'File type is txt';
        case  2:
            return 'File type is image';
        case 3:
            return 'File type is video';
        default :
            return 'Unknown file type';
    }
}

function usePoly(FileType $file)
{
    echo $file->type().PHP_EOL;
}

usePoly(new TextFile());
usePoly(new ImageFile());
usePoly(new VideoFile());
