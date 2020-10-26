<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command {

    protected static $defaultName = 'app:create-user';

    protected function configure(): void {
        $this->addArgument('username', InputArgument::REQUIRED, 'The username of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        $output->writeln('Whoa!');
        $output->writeln('Username: ' . $input->getArgument('username'));
        $output->write('You are about to ');
        $output->write('create a user.');

        return Command::SUCCESS;
    }
}
