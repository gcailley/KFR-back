#
modeError(){
    local output=$1
    echo "ERR - Conversion has failed" 
	touch "${outputFilename}.failure"
    if [ -e "$output" ]; then
        echo "INF - Remove $output"
        unlink $output
        echo "      STATUS : $?"
    fi
}

modeSucess(){
    local input=$1
    local output=$2

    echo "INF - Conversion has successed" 
	touch "${output}.success"
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

inputFilename=$2

outputFilename=$3


echo "########################################## "
echo $ffmpegCmd 
echo $inputFilename 
echo $outputFilename 
echo $outputFilenameLog 
if [ -e "$outputFilename" ]; then
    echo "INF - Remove $outputFilename" 
    unlink $outputFilename
    echo "      STATUS : $?" 
fi

cmd="${ffmpegCmd} -fflags +genpts -i ${inputFilename} -r 24 ${outputFilename}"
echo "INF - $cmd"  

echo $($cmd)
status=$?

echo "INF - $status"  

outputFilenameSize=$(stat -c%s "$outputFilename")

if [[ $(find "$outputFilename" -type f -size +512c 2>/dev/null) ]]; then    
	modeSucess $inputFilename $outputFilename 
    exit 0
else
	modeError $outputFilename 
	exit 1
fi
