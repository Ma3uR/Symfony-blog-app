<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\UserService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateUserCommand extends Command {
    protected static $defaultName = 'app:user-create';
    private UserService $userService;
    private ValidatorInterface $validator;
    private EntityManagerInterface $em;

    public function __construct(UserService $userService, ValidatorInterface $validator, EntityManagerInterface $em) {
        $this->userService = $userService;
        $this->validator = $validator;
        $this->em = $em;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $io = new SymfonyStyle($input, $output);

        $username = $io->ask('Your user name', '', function ($name) {
            if (empty($name)) {
                throw new RuntimeException('You must type a user name.');
            }

            return $name;
        });

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

        $io->title('============ Creating user ============');
        $user = $this->userService->createUser($username, $firstName, $lastName, $password);
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            $message = $errors->get(0);
            throw new \RuntimeException($message->getMessage());
        }
        $this->em->persist($user);
        $this->em->flush();
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
