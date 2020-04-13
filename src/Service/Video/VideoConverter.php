<?php

namespace App\Service\Video;

class VideoConverter
{
    private $working_directory;
    private $video_exec = "C:\\_DATA_\\_DEV_\\KFR\\tools\\ffmpeg-20200403-52523b6-win64-static\\ffmpeg\\bin\\ffmpeg.exe"; // TODO load it from environmnent file


    public function __construct()
    {
        $this->initWorkingDirectory();
    }

    /**
     * create the working directory ifnot existe
     *
     * @return void
     */
    private function initWorkingDirectory() {
        $this->working_directory  = sys_get_temp_dir() . DIRECTORY_SEPARATOR .  "video";
        if (!is_dir ($this->working_directory)) {
            return mkdir ($this->working_directory, 0700, TRUE);
        }
        return true;
    }

    public function convertToMp4($input, $outputFilename, $removeInput = true) {
        // build command 
        $output = $this->working_directory . DIRECTORY_SEPARATOR . md5(uniqid(rand(), true)) . '.mp4';
        $cmd = "$this->video_exec -i ${input} ${output}"; 
        $result = shell_exec($cmd);
        
        if (file_exists ($output)) {
            $infoFilename = pathinfo($outputFilename); 
            if ('mp4' != $infoFilename['extension']) {
                $outputFilename = str_replace("." . $infoFilename['extension'], ".mp4", $outputFilename);
            }
            rename($output, $outputFilename);
            if ($removeInput) {
                unlink($input);
            }
            return $outputFilename;
        } else {
            return $input;
        }
    }


}
