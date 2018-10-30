<?php

namespace PhpAcadem\domain\User\command;


use PhpAcadem\domain\User\UserServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

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
            ->setName('user:init')
            ->setDescription('Database initialization. Create component tables in database')
            ->addOption(
                'admin',
                'a',
                InputOption::VALUE_REQUIRED,
                'Admin login'
            )
            ->addOption(
                'password',
                'p',
                InputOption::VALUE_REQUIRED,
                'Admin password'
            );;
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

        $login = $input->getOption('admin');
        $password = $input->getOption('password');
        if ((!empty($login) && empty($password)) || (empty($login) && !empty($password))) {
            $output->writeln("Please specify both options admin and password");
            exit;
        }

        if (!empty($login) && !empty($password)) {
            $this->userService->register($login, $password);
        }
    }
}