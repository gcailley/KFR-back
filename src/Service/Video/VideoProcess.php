<?php

namespace App\Service\Video;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class VideoProcess extends Process
{
    protected $logger;
    private $cmd;

    public function __construct($logger, $phpExec, $runner, $cmd, $inputFilename, $outputFilename, $debug)
    {
        parent::__construct([$phpExec, $runner, $cmd, $inputFilename, $outputFilename, $debug]);
        $this->cmd = "$phpExec \"$runner\" \"$cmd\" \"$inputFilename\" \"$outputFilename\" &";

        $this->inputFilename = $inputFilename;
        $this->logger = $logger;

        $this->logger->info("input: " . $this->inputFilename);
    }

    public function execute()
    {

        $this->logger->info("Running : $this->cmd ");
        $this->disableOutput();
        $this->setTimeout(3600);
        $this->run();
    }

    public function __destruct()
    {
    }
}
