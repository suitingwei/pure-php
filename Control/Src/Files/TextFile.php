<?php

namespace Control\Src\Files;
use Control\Src\Interfaces\FileType;

class TextFile implements  FileType
{

    public function type()
    {
        return 'My type is text';
    }
}