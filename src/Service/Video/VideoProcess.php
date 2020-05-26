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
        
        if ('true' === $debug || '1' == $debug || 1 == $debug) {
            $this->cmd = "$runner $cmd $inputFilename $outputFilename &> ${outputFilename}.log";
        } else {
            $this->cmd = "$runner $cmd $inputFilename $outputFilename > /dev/null 2>&1";
        }
        
        $this->inputFilename = $inputFilename;
        $this->logger = $logger;

        $this->logger->info("Mode: " . $debug);
        $this->logger->info("Input: " . $this->inputFilename);
    }

    public function execute()
    {
        $this->logger->info("Running : $this->cmd ");
        exec($this->cmd);
    }

}
