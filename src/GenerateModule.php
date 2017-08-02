<?php

namespace PHPCasts;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateModule extends Command
{
    use GenerateTrait;

    protected function configure()
    {
        $this
            ->setName('make:module')
            ->addArgument('module_name', InputArgument::REQUIRED, 'The name of module.')
            ->setDescription('Create new module.')
            ->setHelp('This command allows you create a module in modules.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'generating...',
        ]);

        $moduleName = $input->getArgument('module_name');

        if (defined('APP_PATH')) {
            if (!is_writable(dirname(APP_PATH))) {
                throw new \Exception('Access deny');
            }

            $modulePathWithController = APP_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR  . $moduleName . DIRECTORY_SEPARATOR . 'controllers';
            $result = mkdir($modulePathWithController, 0755, true);
            if (!$result) {
                $output->writeln("make dir: {$modulePathWithController} failure");
                return false;
            }

            $controllerName = 'Index';
            $template = require(__DIR__ . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'Controller.php');
            $data = sprintf($template, $controllerName);
            $this->generate(
                $modulePathWithController . DIRECTORY_SEPARATOR . $controllerName . '.php',
                $data,
                $input,
                $output
            );
            $output->writeln('module ' . $moduleName . ' generate successfully with default controller[Index].');
        } else {
            $output->writeln('generating module failure');
        }
    }
}