<?php

declare(strict_types=1);

namespace WirelessLogic\Symfony\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WirelessLogic\Application\Application;
use WirelessLogic\Domain\Products\Product;

#[AsCommand(name: 'wireless-logic:list-products')]
class ListProductsCommand extends Command
{
    public function __construct(private readonly Application $application)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $products = $this->application->listProducts();

        $productArrays = \array_map(function (Product $product) {
            return $product->toArray();
        }, $products->toArray());

        $output->writeln(\json_encode($productArrays));

        return Command::SUCCESS;
    }
}
