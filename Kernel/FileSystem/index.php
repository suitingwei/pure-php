<?php

require './Src/Dictionary.php';


$result =[];
//FileSystem\Directory::getDirectoryFilesRecursive('/Users/sui/PhpstormProjects',$result);

//print_r($result);

$directory =  new FileSystem\Directory('/Users/sui/PhpstormProjects/PurePHP');


//for ($i=0;$i<999;$i++){
//    $directory->copy('./index.php','./index.php.bak'.$i);
//    $directory->delete('./index.php.bak'.$i);
//    $directory->createFile('tmp-file-'.$i);
//    $directory->delete('tmp-file-'.$i);
//}

#$directory->getDIRSuperVariable();
#echo $directory->getCurrentDirectory().PHP_EOL;
#echo $directory->getCurrentFunctionName().PHP_EOL;
#echo $directory->getDirName('/Users/sui/PhpstormProjects/PurePHP').PHP_EOL;
#echo $directory->getDirFreeSpace('/Users/sui/PhpstormProjects/PurePHP').PHP_EOL;
#echo $directory->humanReadableSize(1024).PHP_EOL;
#print $directory->isFile('/Users/sui/').PHP_EOL;
#$directory->readFileByCharacter('./Src/Dictionary.php').PHP_EOL;
#$directory->readFileByLine('./Src/Dictionary.php').PHP_EOL;
#echo $directory->getFileContents('./Src/Dictionary.php').PHP_EOL;

$directory->createFile('tmpfile');
