<?php

namespace Control\Src\Files;
use Control\Src\Interfaces\FileType;

class ImageFile implements  FileType
{

    public function type()
    {
        return 'My type is image';
    }
}