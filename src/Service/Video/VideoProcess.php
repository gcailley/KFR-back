<?php

namespace App\Service\Video;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class VideoProcess extends Process
{
    protected $logger;
    private $cmd;
    private $debug = true;

    public function __construct($logger, $runner, $cmd, $inputFilename, $outputFilename)
    {
        parent::__construct(['php', $runner, $cmd, $inputFilename, $outputFilename]);
        $this->cmd = "php \"$runner\" \"$cmd\" \"$inputFilename\" \"$outputFilename\"";

        $this->inputFilename = $inputFilename;
        $this->logger = $logger;

        $this->logger->info("input: " . $this->inputFilename);
        //$this->setTimeout(3600);
    }
    public function execute()
    {

        $this->logger->info("Running : $this->cmd ");
        if ($this->debug) {
            $this->logger->info("Debug is ON");
            $stream = fopen('php://temporary', 'w+');
            $this->setInput($stream);
        } else {
            $this->disableOutput();
        }

        $status = $this->start();

        if ($this->debug) {
            fclose($stream);
            $this->wait();
            $this->logger->info($this->getOutput());
        }
    }

    public function __destruct()
    {
    }
}
