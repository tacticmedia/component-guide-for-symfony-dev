<?php

namespace App\Command;

use App\Service\PriceCalculator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:report', 'Prints the price of a sample order')]
final class ReportCommand
{
    public function __construct(private readonly PriceCalculator $calculator)
    {
    }

    public function __invoke(SymfonyStyle $io, #[Option('Number of previous orders')] int $orders = 0): int
    {
        $io->table(['Net', 'Final'], [[100, $this->calculator->finalPrice(100, $orders)]]);

        return Command::SUCCESS;
    }
}
