<?php
$source = dirname(__FILE__)."/assets";
$dest = dirname(__DIR__)."/elastic-email-shared";

if(!is_dir($dest)){
mkdir($dest);
}
if(is_dir($source))
{
    
foreach ($iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST) as $item)
{
    if ($item->isDir())
        mkdir($dest.DIRECTORY_SEPARATOR.$iterator->getSubPathName());
    else
        copy($item, $dest.DIRECTORY_SEPARATOR.$iterator->getSubPathName());
}

  $dir= $source;
        
$di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
foreach ( $ri as $file ) {
    $file->isDir() ?  rmdir($file) : unlink($file);
}

    rmdir($dir);          
}
else
{
    return 0;
}

?>