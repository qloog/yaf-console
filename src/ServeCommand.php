<?php

namespace PHPCasts\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Console\Input\InputInterface;

class ServeCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('serve')
            ->addOption('host', null, InputOption::VALUE_OPTIONAL, 'The host address to serve the application on.', 'localhost')
            ->addOption('port', null, InputOption::VALUE_OPTIONAL, 'The port to serve the application on.', 8000)
            ->setDescription('Serve the application on the PHP development server')
            ->setHelp('This command allows you run a local serve.');
    }

    /**
     * Execute the console command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (!defined('ROOT_PATH')) {
            $this->$this->output->writeln("Not have define ROOT_PATH in bin/Console");
            return;
        }
        chdir(ROOT_PATH);

        $host = $input->getOption('host');

        $port = $input->getOption('port');

        $base = ROOT_PATH;

        $binary = (new PhpExecutableFinder)->find(false);

        $output->writeln("YAF development server started on http://{$host}:{$port}/");

        passthru("{$binary} -S {$host}:{$port} {$base}/server.php");
    }
}
