<?php

namespace PhpAcadem\domain\User\command;


use PhpAcadem\domain\User\UserServiceInterface;
use Symfony\Component\Console\Command\Command;

class InitCommand extends Command
{
    public const COMMAND_NAME = 'user:init';
    public const COMMAND_ERROR = 1;

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
            ->setName(self::COMMAND_NAME)
            ->setDescription('Database initialization. Create component tables in database');
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        try {
            $sqlAll = file_get_contents(__DIR__ . "/schema/init.sql");
            $sqls = explode(';', $sqlAll);

            foreach ($sqls as $sql) {
                $sql = trim($sql);
                if (empty($sql)) {
                    continue;
                }
                $result = $this->pdo->query($sql . ';');
            }
        } catch (\Throwable $e) {
            return self::COMMAND_ERROR;
        }

    }
}