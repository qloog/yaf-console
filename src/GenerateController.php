<?php

namespace PHPCasts;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateController extends Command
{
    use GenerateTrait;

    protected function configure()
    {
        $this
            ->setName('make:controller')
            ->addArgument('controller_name', InputArgument::REQUIRED, 'The name of controller.')
            ->setDescription('Create new controller.')
            ->setHelp('This command allows you create a controller.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'generating...',
        ]);

        $controller_name = $input->getArgument('controller_name');

        if (defined('APP_PATH')) {
            $template = require(__DIR__ . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'Controller.php');
            $data = sprintf($template, $controller_name);
            $this->generate(
                APP_PATH . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $controller_name . '.php',
                $data,
                $input,
                $output
            );
            $output->writeln('controller ' . $controller_name . ' generate successfully.');
        } else {
            $output->writeln('generating controller failure');
        }
    }
}