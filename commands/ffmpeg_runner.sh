modeError(){
    local output=$1
    local log=$2

    echo "ERR - Conversion has failed"  >> $log
    if [ -e "$output" ]; then
        echo "INF - Remove $output" >> $log
        unlink $output
        echo "      STATUS : $?" >> $log
    fi
}

modeSucess(){
    local input=$1
    local output=$2
    local log = $3

    echo "INF - Conversion has successed"  >> $log
    if [ -e "$output" ]; then
        echo "INF - Remove $input" >> $log
        unlink $input
        echo "      STATUS : $?" >> $log

        echo "INF - Move $input => $output" >> $log
        mv $output $input
        echo "      STATUS : $?" >> $log

    fi
}

ffmpegCmd=$1;
inputFilename=$2;outputFilename=$3;outputFilenameLog="$3.log";

echo "########################################## " > $outputFilenameLog
echo $ffmpegCmd >> $outputFilenameLog
echo $inputFilename >> $outputFilenameLog
echo $outputFilename >> $outputFilenameLog
echo $outputFilenameLog >> $outputFilenameLog
if [ -e "$outputFilename" ]; then
    echo "INF - Remove $outputFilename" >> $outputFilenameLog
    unlink $outputFilename
    echo "      STATUS : $?" >> $outputFilenameLog
fi

cmd="${ffmpegCmd} -i ${inputFilename} ${outputFilename} > ${outputFilename}.ffmpeg.log 2>&1"
echo "INF - $cmd"  >> $outputFilenameLog

$($cmd)
status=$?

echo "INF - $status"  >> $outputFilenameLog

if [ "$status" != "0" ]
then
	modeError $outputFilename  $outputFilenameLog
    exit 1
else
	modeSucess $inputFilename $outputFilename $outputFilenameLog
    exit 0
fi