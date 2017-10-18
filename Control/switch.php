<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2017/10/12
 * Time: 13:43
 */


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

interface FileType
{
    public function type();
}

class TextFile implements FileType
{

    public function type()
    {
        return 'My type is text';
    }
}

class VideoFile implements FileType
{

    public function type()
    {
        return 'My type is video';
    }
}

class ImageFile implements FileType
{

    public function type()
    {
        return 'My type is image';
    }
}

class UnknownFile implements FileType
{

    public function type()
    {
        return 'Even myself don\'t know which type i am';
    }
}

function usePoly(FileType $file)
{
    echo $file->type();
}

echo useSwitch(1);
usePoly(new UnknownFile());
