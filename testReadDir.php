<?php
$dir = dirname(__FILE__).'/内网全天';
$dir = iconv('utf-8', 'gb2312', $dir);
$file = scandir($dir);
//$file = iconv('utf-8', 'gb2312', $file);
$fileChoose = array_slice($file, 2);
foreach ($fileChoose as $fileNameEach)
{
    echo $fileNameEach;
    echo "<br>";
}
