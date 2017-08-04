<?php

namespace PHPCasts\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Check extends Command
{

    protected function configure()
    {
        $this
            ->setName('check')
            ->setDescription('Check the environment.')
            ->setHelp('This command allows you to check environment.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'checking...',
        ]);

        $loadedExtension = get_loaded_extensions();
        $isLoadedYafExtension = in_array('yaf', $loadedExtension);
        $output->writeln($isLoadedYafExtension ? "yaf extension: <fg=green>loaded</>" : "yaf extension: <fg=red>unloaded</>");

        $isUseNamespace = ini_get('yaf.use_namespace');
        $output->writeln($isUseNamespace ? "yaf.use_namespace: <fg=green>on</>" : "<fg=red>off</>");

        $isUseSplAutoload = ini_get('yaf.use_spl_autoload');
        $output->writeln($isUseSplAutoload ? "yaf.use_spl_autoload: <fg=green>on</>" : "<fg=red>off</>");
    }
}