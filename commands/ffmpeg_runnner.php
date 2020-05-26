<?php

$ffmpegCmd = str_replace(' ',"\\ ", $argv[1]);
$rawInputFilename = $argv[2];
$inputFilename = str_replace(' ',"\\ ", $argv[2]);
$rawOutputFilename = $argv[3];
$outputFilename = str_replace(' ',"\\ ", $argv[3]);
print("########################################## ");

print($ffmpegCmd . '\n' );
print($inputFilename . '\n');
print($outputFilename . '\n');

$cmd="${ffmpegCmd} -i ${inputFilename} -y ${outputFilename}";
print($cmd . '\n' );

$status = exec($cmd);
print("status => $status" );

if (file_exists($rawOutputFilename) ) {	
    print($rawOutputFilename . " converted. ");

    if (file_exists($rawInputFilename)) {
        print("try to delete " + $rawInputFilename);
        if (unlink($rawInputFilename)) {
            print($rawInputFilename . " deleted. ");
        } else {
            print($inputFilename . " NOT deleted. ");
        }
    } else {
        print($rawInputFilename . " does NOT exist. ");
    }

    if (rename($rawOutputFilename, $rawInputFilename)) {
        print($rawOutputFilename . " renamed. ");
    } else {
        print($rawOutputFilename . " NOT renamed. ");
    }

} else {	
    print($rawOutputFilename . " not converted. ");}
    print("##########################################");
?>