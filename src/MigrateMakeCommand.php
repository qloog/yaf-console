<?php

namespace PHPCasts\Yaf\Console;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Composer;
use Illuminate\Database\Migrations\MigrationCreator;

class MigrateMakeCommand extends Command
{
    use GenerateTrait;

    protected function configure()
    {
        $this
            ->setName('make:migration')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the migration.')
            ->addOption('create', null, null, 'The table to be created.')
            ->addOption('table', null, null, 'The table to migrate.')
            ->addOption('path', null, null, 'The location where the migration file should be created.')
            ->setDescription('Create a new migration file')
            ->setHelp('This command allows you create a migration.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'generating...',
        ]);

        // It's possible for the developer to specify the tables to modify in this
        // schema operation. The developer may also specify if this table needs
        // to be freshly created so we can create the appropriate migrations.
        $name = trim($input->getArgument('name'));
        $table = $input->getOption('table');
        $create = $input->getOption('create') ?: false;

        // If no table was given as an option but a create option is given then we
        // will use the "create" option as the table name. This allows the devs
        // to pass a table name into this option as a short-cut for creating.
        if (! $table && is_string($create)) {
            $table = $create;

            $create = true;
        }

        // Next, we will attempt to guess the table name if this the migration has
        // "create" in the name. This will allow us to provide a convenient way
        // of creating migrations that create new tables for the application.
        if (! $table) {
            if (preg_match('/^create_(\w+)_table$/', $name, $matches)) {
                $table = $matches[1];

                $create = true;
            }
        }

        // Now we are ready to write the migration out to disk. Once we've written
        // the migration out, we will dump-autoload for the entire framework to
        // make sure that the migrations are registered by the class loaders.

        // Write the migration file to disk.
        $fileSystem = new Filesystem();
        $file = pathinfo((new MigrationCreator($fileSystem))->create(
            $name, $this->getMigrationPath($input), $table, $create
        ), PATHINFO_FILENAME);

        (new Composer($fileSystem))->dumpAutoloads();

        $output->writeln("\"<info>Created Migration:</info> {$file}\"");
    }

    public function getMigrationPath(InputInterface $input)
    {
        if (! is_null($targetPath = $input->getOption('path'))) {
            return APP_ROOT . '/' . $targetPath;
        }

        return DATABASE_PATH . DIRECTORY_SEPARATOR . 'migrations';
    }
}