<?php

define('PROJECT_ROOT', dirname(__DIR__));
require PROJECT_ROOT . "/vendor/autoload.php";

try {

    $container = require PROJECT_ROOT . '/config/bootstrap.php';

    $cli = new \Symfony\Component\Console\Application('Application console');
    foreach ($container->get('commands') as $command) {
        $cli->add($command);
    }
    $cli->add(new class($container->get(PDO::class)) extends \Symfony\Component\Console\Command\Command
    {
        protected $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
            parent::__construct();
        }

        protected function configure(): void
        {
            $this
                ->setName('db:init')
                ->setDescription('Database initialization');
        }

        protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
        {

            if (!file_exists(__DIR__ . "/../db/db.sqlite")) {
                $fh = fopen('__DIR__ . "/../db/db.sqlite"', 'w');
                fclose($fh);
            }

            if (file_exists(__DIR__ . "/../db/init.sql")) {
                $sqlAll = file_get_contents(__DIR__ . "/../db/init.sql");
                $sqls = explode(';', $sqlAll);

                foreach ($sqls as $sql) {
                    if (empty($sql)) {
                        continue;
                    }
                    $result = $this->pdo->query($sql . ';');
                }
            }
        }
    });
    $cli->run();


} catch (\Throwable $e) {
    dump($e);
}