<?php

$ffmpegCmd = $argv[1];
$inputFilename = $argv[2];
$outputFilename = $argv[3];

printf($ffmpegCmd ." ## ");
printf($inputFilename  ." ## ");
printf($outputFilename  ." ## ");

$cmd="\"$ffmpegCmd\" -i \"$inputFilename\" -y \"$outputFilename\"";
printf($cmd ." ## ");
exec($cmd);  

if (file_exists($outputFilename) ) {
    unlink($inputFilename);
    rename($outputFilename, $inputFilename);
}

?>