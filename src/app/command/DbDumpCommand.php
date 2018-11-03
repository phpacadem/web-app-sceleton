<?php

namespace app\command;


class DbDumpCommand extends \Symfony\Component\Console\Command\Command
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
            ->setName('db:dump')
            ->setDescription('Dump databse');
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
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


        $schemaDumpCmd = "sqlite3 {$sqliteDbFile} .schema > {$sqliteSchemaDump}";
        $fullDumpCmd = "sqlite3 {$sqliteDbFile} .dump > {$sqliteFullDump}";
        $dataDumpCmd = "grep -vx -f {$sqliteSchemaDump} {$sqliteFullDump} > {$sqliteDataDump}";

        exec($schemaDumpCmd);
        if (file_exists($sqliteSchemaDump)) {
            $output->writeln('schema dump  - ok');
        }
        exec($fullDumpCmd);
        if (file_exists($sqliteFullDump)) {
            $output->writeln('full dump  - ok');
        }
        exec($dataDumpCmd);
        if (file_exists($sqliteDataDump)) {
            $output->writeln('data dump  - ok');
        }


    }
}