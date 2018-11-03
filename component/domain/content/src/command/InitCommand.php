<?php

namespace PhpAcadem\domain\Content\command;


use PhpAcadem\domain\User\UserServiceInterface;
use Symfony\Component\Console\Command\Command;

class InitCommand extends Command
{
    protected $pdo;
    protected $userService;

    public function __construct(\PDO $pdo, UserServiceInterface $userService)
    {
        $this->pdo = $pdo;
        $this->userService = $userService;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('content:init')
            ->setDescription('Database initialization. Create component tables in database');
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $sqlAll = file_get_contents(__DIR__ . "/schema/init.sql");
        $sqls = explode(';', $sqlAll);

        foreach ($sqls as $sql) {
            if (empty($sql)) {
                continue;
            }
            $result = $this->pdo->query($sql . ';');
        }
    }
}