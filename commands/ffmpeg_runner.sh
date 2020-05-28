modeError(){
    echo "ERR - Conversion has failed"
    local output=$1
    if [ -e "$output" ]; then
        echo "INF - Remove $output"
        unlink $output
        echo "      STATUS : $?"        
    fi
}

modeSucess(){
    echo "INF - Conversion has successed"

    local input=$1
    local output=$2

    if [ -e "$output" ]; then
        echo "INF - Remove $input"
        unlink $input
        echo "      STATUS : $?"        

        echo "INF - Move $input => $output"
        mv $output $input
        echo "      STATUS : $?"        

    fi
}

ffmpegCmd=$1;
inputFilename=$2;
outputFilename=$3;

echo "########################################## "
echo $ffmpegCmd
echo $inputFilename
echo $outputFilename

if [ -e "$outputFilename" ]; then
    echo "INF - Remove $outputFilename"
    unlink $outputFilename
    echo "      STATUS : $?"
fi

cmd="${ffmpegCmd} -i ${inputFilename} ${outputFilename}"
echo "INF - $cmd"

$($cmd)
status=$?

if [ "$status" != "0" ]
then
	modeError $outputFilename
    exit 1
else
	modeSucess $inputFilename $outputFilename
    exit 0
fi

