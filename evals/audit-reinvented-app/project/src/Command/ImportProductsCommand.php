<?php

namespace App\Command;

use App\Service\ImportLock;
use App\Service\PartnerApiClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:import-products', 'Imports the product feed of the partner')]
final class ImportProductsCommand
{
    public function __construct(
        private readonly ImportLock $lock,
        private readonly PartnerApiClient $partner,
    ) {
    }

    public function __invoke(SymfonyStyle $io): int
    {
        if (!$this->lock->acquire()) {
            $io->warning('Another import is running.');

            return Command::SUCCESS;
        }

        try {
            foreach ($this->partner->fetchProducts() as $product) {
                $io->writeln($product['sku']);
            }
        } finally {
            $this->lock->release();
        }

        return Command::SUCCESS;
    }
}
