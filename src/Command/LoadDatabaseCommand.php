<?php

namespace App\Command;

use App\Entity\Tools\Sql\RtlqDatabaseVersion;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class LoadDatabaseCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:load-database';


    /** KernelInterface $appKernel */
    private $appKernel;
    private $container;

    public function __construct(KernelInterface $appKernel, ContainerInterface $container)
    {
        parent::__construct();
        $this->appKernel = $appKernel;
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Load database resource files.')
            ->addOption('initialisation', false, InputOption::VALUE_OPTIONAL, 'Permettant de faire une initialisation de la base', false)
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to load database resource files.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('option : ' . $input->getOption('initialisation'));
        $output->writeln('Loading ressource files.');
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $sqlFiles = $this->getRessourceFiles($output);
        $output->writeln('find ' . sizeof($sqlFiles) . ' files.');

        $output->writeln('Checking ressource files.');
        $em = $this->container->get('doctrine')->getManager();
        foreach ($sqlFiles as $sqlFile) {
            $RtlqDatabaseVersionRepo = $em->getRepository(RtlqDatabaseVersion::class);
            $fileIntoDb = $RtlqDatabaseVersionRepo->findBy(array("resourceName" => basename($sqlFile)));

            if (null == $fileIntoDb) {
                $entityMetier = new RtlqDatabaseVersion();
                $entityMetier->setResourceName(basename($sqlFile));
                try {
                    if (! $input->getOption('initialisation')) {
                        // executing script //
                        $sql = file_get_contents($sqlFile);
                        $output->writeln('Processing :: ' . basename($sqlFile) . '  [SQL]');
                        $output->writeln($sql);
                        $em->getConnection()->exec($sql);
                    } else {
                        $output->writeln('Processing :: ' . basename($sqlFile) . '  [INITIALISATION]');
                    }
                    $entityMetier->setEtat(true);
                    $em->merge($entityMetier);
                    $em->flush();
                    $output->writeln(' -- [DONE]');
                } catch (\Throwable $th) {
                    $output->writeln(' -- [KO]');
                    throw new Exception($th);
                }
            } else {
                $output->writeln('Processing :: ' . basename($sqlFile) . '  [SKIP]');
            }
        }


        return 0;
    }


    /**
     * récupération du contenu du répertoire resource SQL.
     */
    private function getRessourceFiles($output)
    {
        $dir = $this->appKernel->getProjectDir() . '/src/Resources/sql';
        $output->writeln('Directory : ' . $dir);
        $result = [];

        $cdir = scandir($dir);
        foreach ($cdir as $key => $value) {
            if (!in_array($value, ['.', '..']) && preg_match("/.*\.sql/i", $value)) {
                $result[] = $dir . '/' . $value;
            }
        }
        return $result;
    }
}
