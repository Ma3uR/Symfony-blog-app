<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Service\UserService;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateUserCommand extends Command {
    protected static $defaultName = 'app:user-create';
    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $io = new SymfonyStyle($input, $output);

        $firstName = $io->ask('Your first name', '', function ($name) {
            if (empty($name)) {
                throw new RuntimeException('You must type a first name.');
            }

            return $name;
        });

        $lastName = $io->ask('Your last name', '', function ($name) {
            if (empty($name)) {
                throw new RuntimeException('You must type a last name.');
            }

            return $name;
        });

        $password = $io->askHidden('What is your password?', function ($password) {
            if (empty($password)) {
                throw new RuntimeException('Password cannot be empty.');
            }

            return $password;
        });

        // TODO: fix logic
        $user = new User();
        $user->setUsername("$firstName$lastName");
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPassword($password);

        $username = "$firstName$lastName";
        $io->title('============ Creating user ============');
        $this->userService->createAndPersist($user);
        $io->section('Generating the user');
        $io->horizontalTable(
            ['Username', 'First Name', 'Last Name'],
            [[$username, $firstName, $lastName],]
        );
        $io->title('============= User created =============');
        $io->newLine();

        return Command::SUCCESS;
    }
}
