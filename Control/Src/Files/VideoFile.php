<?php

namespace Control\Src\Files;
use Control\Src\Interfaces\FileType;

class VideoFile implements  FileType
{

    public function type()
    {
        return 'My type is video ';
    }
}