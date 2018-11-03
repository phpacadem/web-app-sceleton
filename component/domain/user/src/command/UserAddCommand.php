<?php

namespace PhpAcadem\domain\User\command;


use PhpAcadem\domain\User\UserServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

class UserAddCommand extends Command
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
            ->setName('user:add')
            ->setDescription('User adding')
            ->addOption(
                'user',
                'u',
                InputOption::VALUE_REQUIRED,
                'User login'
            )
            ->addOption(
                'password',
                'p',
                InputOption::VALUE_REQUIRED,
                'User password'
            )
            ->addOption(
                'admin',
                'a',
                InputOption::VALUE_NONE,
                'Admin'
            );
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {

        $login = $input->getOption('user');
        $password = $input->getOption('password');
        $isAdmin = $input->getOption('admin');
        if (empty($login) || empty($password)) {
            $output->writeln("Please specify both options admin and password");
            exit;
        }

        if (!empty($login) && !empty($password)) {
            if ($isAdmin) {
                $this->userService->create($login, $password, ['admin']);
            } else {
                $this->userService->register($login, $password);
            }
        }
    }
}