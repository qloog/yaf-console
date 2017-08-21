<?php

namespace PHPCasts\Console;

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

        // {module}/{controller} or {controller}
        $controllerName = $input->getArgument('controller_name');

        if (defined('APP_PATH')) {
            // eg: {module}/{controller}
            if (count($moduleController = explode('/', $controllerName)) == 2) {
                $moduleName = ucfirst($moduleController[0]);
                $controllerName = ucfirst($moduleController[1]);
                $controllerPath = APP_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR  . $moduleName . DIRECTORY_SEPARATOR . 'controllers';
                if (!file_exists($controllerPath)) {
                    throw new \Exception("module:{$moduleName} is not exist, you can use: make:module to generate.");
                }
            } else {
                $controllerPath = APP_PATH . DIRECTORY_SEPARATOR . 'controllers';
                $controllerName = ucfirst($controllerName);
            }

            $template = require(__DIR__ . DIRECTORY_SEPARATOR . 'Stubs' . DIRECTORY_SEPARATOR . 'Controller.stub');
            $data = sprintf($template, $controllerName);
            $this->generate(
                $controllerPath . DIRECTORY_SEPARATOR . $controllerName . '.php',
                $data,
                $input,
                $output
            );
            $output->writeln('<info>controller ' . $controllerName . ' generate successfully.</info>');
        } else {
            $output->writeln('<error>generating controller failure.</error>');
        }
    }
}