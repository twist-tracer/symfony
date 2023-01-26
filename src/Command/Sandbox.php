<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'sandbox',
    description: 'Command for tests',
    hidden: false,
)]
class Sandbox extends Command
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {


        return Command::SUCCESS;
    }
}