<?php

declare(strict_types=1);

namespace App\Command;

use App\Enum\Role;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use App\Repository\UserRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

#[AsCommand(
    name: 'rentcar:user:role',
    description: 'Setting user role for specific user'
)]
class SetUserRoleCommand extends Command
{
    public function __construct(private readonly UserRepository $userRepository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to set up role for the specific
         user. You need to pass email of the user and the desired role for that specific user')
         ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
         ->addArgument('role', InputArgument::REQUIRED, 'The role of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $role = $input->getArgument('role');
        $userEmail = $input->getArgument('email');
        $user = $this->userRepository->findOneBy(['email' => $userEmail]);


        if (null === $user) {
              throw new Exception("No user found with that email");
        }

        $validRoles = Role::getAllValues();

        if (!in_array($role, $validRoles)) {
            throw new \InvalidArgumentException(sprintf('Invalid role "%s".', $role));
        }

        $user->setRole(Role::from($role));
        $this->userRepository->save($user);
        $output->writeln('User role successfully changed');

        return Command::SUCCESS;
    }
}