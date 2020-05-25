<?php

namespace App\Service\Video;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class VideoProcess
{
    protected $logger;
    private $cmd;

    public function __construct($logger, $phpExec, $runner, $cmd, $inputFilename, $outputFilename, $debug)
    {
        $this->cmd = "$phpExec \"$runner\" \"$cmd\" \"$inputFilename\" \"$outputFilename\" $debug &";
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
