<?php

namespace PHPCasts\Yaf\Console;

use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Composer;
use Illuminate\Database\Migrations\MigrationCreator;

class MigrateCommand extends Command
{
    use GenerateTrait;

    protected function configure()
    {
        $this
            ->setName('migrate')
            ->addOption('database', null, null, 'The database connection to use.')
            ->addOption('force', null, null, 'Force the operation to run when in production.')
            ->addOption('pretend', null, null, 'Dump the SQL queries that would be run.')
            ->addOption('seed', null, null, 'Indicates if the seed task should be re-run.')
            ->addOption('step', null, null, 'Force the migrations to be run so they can be rolled back individually.')
            ->setDescription('Run the database migrations')
            ->setHelp('This command allows you create a migration.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'generating...',
        ]);

        // Next, we will check to see if a path option has been defined. If it has
        // we will use the path relative to the root of this installation folder
        // so that migrations may be run for any path within the applications.
        $resolver = new ConnectionResolver();
        $migrator = new Migrator(
            new DatabaseMigrationRepository($resolver, ''),
            $resolver,
            new Filesystem()
        );
        $migrator->run($this->getMigrationPath(), [
            'pretend' => $input->getOption('pretend'),
            'step' => $input->getOption('step'),
        ]);

        // Once the migrator has run we will grab the note output and send it out to
        // the console screen, since the migrator itself functions without having
        // any instances of the OutputInterface contract passed into the class.
        foreach ($migrator->getNotes() as $note) {
            $output->writeln($note);
        }
    }

    public function getMigrationPath()
    {
        return DATABASE_PATH . DIRECTORY_SEPARATOR . 'migrations';
    }
}