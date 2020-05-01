<?php

namespace App\Service\Video;

use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\UnsetKeyException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\Process\Process;

class VideoConverterService
{
    private $logger;
    /**
     * @var ContainerInterface
     */
    protected $container;
    private $key_video_exec = "ffmpeg";
    
    private $working_directory;
    private $video_exec;
    private $video_runner;
    private $enable = true;


    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @internal
     * @required
     */
    public function setContainer(ContainerInterface $container): ?ContainerInterface
    {
        $previous = $this->container;
        $this->container = $container;

        $this->init();

        return $previous;
    }


    private function init()
    {
        $this->video_exec = $this->getParameter($this->key_video_exec)["cmd"];
        if ($this->video_exec == null) {
            throw new UnsetKeyException($this->key_video_exec . " not initialized.");
        }
        $this->video_runner = $this->getParameter($this->key_video_exec)["runner"];
        if ($this->video_runner == null) {
            throw new UnsetKeyException($this->key_video_exec . " not initialized.");
        }
        $this->initWorkingDirectory();
    }

    /**
     * Gets a container parameter by its name.
     *
     * @return mixed
     *
     * @final
     */
    protected function getParameter(string $name)
    {
        $param = $this->container->getParameter($name);
        if ($param == null) {
            throw new ServiceNotFoundException('parameters', null, null, [], sprintf('The "%s::getParameter()" method is missing a parameter bag to work properly. Did you forget to register your controller as a service subscriber? This can be fixed either by using autoconfiguration or by manually wiring a "parameter_bag" in the service locator passed to the controller.', \get_class($this)));
        }

        return $param;
    }
    /**
     * create the working directory ifnot existe
     *
     * @return void
     */
    private function initWorkingDirectory()
    {
        $this->working_directory  = sys_get_temp_dir() . DIRECTORY_SEPARATOR .  "video";
        if (!is_dir($this->working_directory)) {
            return mkdir($this->working_directory, 0700, TRUE);
        }
        return true;
    }

    public function convertToMp4($inputFilename, $outputFilename)
    {
        
        if ($this->enable) {
            $this->logger->info("Converting  ${outputFilename}");
            $process = new VideoProcess($this->logger, $this->video_runner,  $this->video_exec, $inputFilename, $outputFilename);
            $process->execute();

            $pid = $process->getPid();
            $this->logger->info("Converting with PID : ${pid}");
        }  else {
            $this->logger->info("Converter disabled");
        }

    }
}
