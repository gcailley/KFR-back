<?php

namespace App\Service\Video;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class VideoProcess
{
    protected $logger;
    private $cmd;

    public function __construct($logger, $runner, $cmd, $inputFilename, $outputFilename, $debug)
    {
        
        if ('true' === $debug) {
            $this->cmd = "\"$runner\" \"$cmd\" \"$inputFilename\" \"$outputFilename\" & > ${outputFilename}.log";
        } else {
            $this->cmd = "\"$runner\" \"$cmd\" \"$inputFilename\" \"$outputFilename\" &";
        }
        
        $this->inputFilename = $inputFilename;
        $this->logger = $logger;

        $this->logger->info("input: " . $this->inputFilename);
    }

    public function execute()
    {
        $this->logger->info("Running : $this->cmd ");
        exec($this->cmd);
    }

}
