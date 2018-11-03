<?php

namespace app\command;


use Symfony\Component\Console\Input\InputOption;

class DbImportCommand extends \Symfony\Component\Console\Command\Command
{
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('db:import')
            ->setDescription('Import databse dump')
            ->addOption(
                'full',
                'f',
                InputOption::VALUE_NONE,
                'Full import'
            )
            ->addOption(
                'schema',
                's',
                InputOption::VALUE_NONE,
                'Schema import'
            )
            ->addOption(
                'data',
                'd',
                InputOption::VALUE_NONE,
                'Data import'
            );
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {

        $isFull = $input->getOption('full');
        $isSchema = $input->getOption('schema');
        $isData = $input->getOption('data');

        if (!$isFull && !$isData && !$isSchema) {
            $output->writeln('Have to specify import type. Use --help for description.');
        }


        chdir(__DIR__ . "/../../../db/");
        if (!file_exists("dump")) {
            mkdir("dump");
        }


        $sqliteDbFile = "db.sqlite";
        $sqliteSchemaDump = "dump/schema.sql";
        $sqliteFullDump = "dump/dump.sql";
        $sqliteDataDump = "dump/data.sql";

        if (!file_exists($sqliteDbFile)) {
            $output->writeln("NO DB FILE!");
            exit;
        }

        if ($isSchema) {
            $this->execSqlFile($sqliteDbFile, $sqliteSchemaDump, $output);
        } else if ($isData) {
            $this->execSqlFile($sqliteDbFile, $sqliteDataDump, $output);
        } else if ($isFull) {
            $this->execSqlFile($sqliteDbFile, $sqliteFullDump, $output);
        }

    }

    protected function execSqlFile($sqliteDbFile, $file, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        if (file_exists($file)) {

            exec("cat {$file} | sqlite3 {$sqliteDbFile}");
        } else {
            $output->writeln("NO FILE {$file} !");
        }
    }
}