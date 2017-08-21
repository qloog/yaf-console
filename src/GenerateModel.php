<?php

namespace PHPCasts\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateModel extends Command
{
    use GenerateTrait;

    protected function configure()
    {
        $this
            ->setName('make:model')
            ->addArgument('model_name', InputArgument::REQUIRED, 'The name of model.')
            ->setDescription('Create new model.')
            ->setHelp('This command allows you create a model.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'generating...',
        ]);

        $model_name = $input->getArgument('model_name');

        if (defined('APP_PATH')) {
            $template = require(__DIR__ . DIRECTORY_SEPARATOR . 'Stubs' . DIRECTORY_SEPARATOR . 'Model.stub');
            $data = sprintf($template, $model_name);
            $this->generate(
                APP_PATH . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $model_name . '.php',
                $data,
                $input,
                $output
            );
            $output->writeln('model ' . $model_name . ' generate successfully.');
        } else {
            $output->writeln('generating model failure');
        }
    }
}