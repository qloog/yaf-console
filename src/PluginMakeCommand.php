<?php

namespace PHPCasts\Yaf\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PluginMakeCommand extends Command
{
    use GenerateTrait;

    protected function configure()
    {
        $this
            ->setName('make:plugin')
            ->addArgument('plugin_name', InputArgument::REQUIRED, 'The name of plugin.')
            ->setDescription('Create new plugin.')
            ->setHelp('This command allows you create a plugin.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'generating...',
        ]);

        $plugin_name = $input->getArgument('plugin_name');

        if (defined('APP_PATH')) {
            $template = require(__DIR__ . DIRECTORY_SEPARATOR . 'Stubs' . DIRECTORY_SEPARATOR . 'Plugin.stub');
            $data = sprintf($template, $plugin_name);
            $this->generate(
                APP_PATH . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . $plugin_name . '.php',
                $data,
                $input,
                $output
            );
            $output->writeln('plugin ' . $plugin_name . ' generate successfully.');
        } else {
            $output->writeln('generating plugin failure');
        }
    }
}