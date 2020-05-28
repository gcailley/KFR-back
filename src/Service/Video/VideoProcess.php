<?php

namespace App\Service\Video;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class VideoProcess
{
    protected $logger;
    private $cmd;
    private $process;
    private $debug;

    public function __construct($logger, $runner, $cmd, $inputFilename, $outputFilename, $debug)
    {

        if ('true' === $debug || '1' == $debug || 1 == $debug) {
            $this->cmd = "$runner $cmd $inputFilename $outputFilename &> ${outputFilename}.log";
            $this->process = new Process([$runner, $cmd, $inputFilename, $outputFilename]);
            $this->debug = true;
        } else {
            $this->cmd = "$runner $cmd $inputFilename $outputFilename > /dev/null 2>&1";
            $this->debug = false;
        }

        $this->inputFilename = $inputFilename;
        $this->logger = $logger;

        $this->logger->info("Mode: " . $debug);
        $this->logger->info("Input: " . $this->inputFilename);
    }

    public function execute()
    {
        if ($this->debug) {
            $this->logger->info("Running : $this->cmd ");
            $this->process->disableOutput();
            $this->process->run();
        } else {
            $this->logger->info("Running : $this->cmd ");
            exec($this->cmd);
        }
    }
}
