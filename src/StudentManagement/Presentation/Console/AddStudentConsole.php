<?php

namespace Classroom\StudentManagement\Presentation\Console;

use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\SharedContext\Infrastructure\Framework\Symfony\Messenger\MessengerCommandBus;
use Classroom\StudentManagement\Application\UseCase\Command\AddStudent;
use Classroom\StudentManagement\Domain\Model\Factory\AddressFactory;
use Classroom\StudentManagement\Domain\Model\ValueObject\Username;
use DateTimeImmutable;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(
    name: 'app:add-student',
    description: 'Add a student',
)]
class AddStudentConsole extends Command
{
    public function __construct(
        private readonly AddressFactory $addressFactory,
        private readonly MessengerCommandBus $commandBus
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('username', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('birthdate', InputArgument::REQUIRED, 'Argument description')
            ->addOption('city', null, InputOption::VALUE_REQUIRED, 'Option description')
            ->addOption('country', null, InputOption::VALUE_REQUIRED, 'Option description')
            ->addOption('line1', null, InputOption::VALUE_REQUIRED, 'Option description')
            ->addOption('line2', null, InputOption::VALUE_REQUIRED, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $email = new Email($input->getArgument('email'));
            $username = new Username($input->getArgument('username'));
            $birthdate = new DateTimeImmutable($input->getArgument('birthdate'));
            $address = $this->addressFactory->create(
                $input->getOption('city'),
                $input->getOption('country'),
                $input->getOption('line1'),
                $input->getOption('line2')
            );
        } catch (Throwable $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        try {
            $this->commandBus->handle(new AddStudent(
                $email,
                $username,
                $address,
                $birthdate
            ));
        } catch (\DomainException $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        $io->success('Student added');

        return Command::SUCCESS;
    }
}
