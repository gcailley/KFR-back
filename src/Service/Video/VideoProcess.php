<?php

use Symfony\Component\Process\Process;

class VideoProcess extends Process
{
    protected $logger;
    public function __construct($logger, $cmd, $inputFilename, $outputFilename)
    {
        parent::__construct([$cmd, "-i", $inputFilename, "-y", $outputFilename]);
        $this->logger = $logger;
        $this->setTimeout(3600);
        $this->disableOutput();
    }
    public function start()
    {
        return parent::start(
            function ($data) {
               $this->logger->error(json_encode($data));
            },

        );
    }

    public function __destruct()
    {
    }
}
