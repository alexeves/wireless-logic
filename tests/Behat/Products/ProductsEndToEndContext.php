<?php

declare(strict_types=1);

namespace WirelessLogic\Tests\Behat\Products;

use Behat\Behat\Context\Context;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use WirelessLogic\Application\Application;
use WirelessLogic\Domain\Products\HtmlProductParser;
use WirelessLogic\Domain\Products\ProductCollectionFactory;
use WirelessLogic\Infrastructure\Products\HtmlProductRepository;
use WirelessLogic\Symfony\Console\ListProductsCommand;

final class ProductsEndToEndContext implements Context
{
    private int $result;

    private string $output;

    public function __construct(private readonly string $productSource)
    {
    }

    /**
     * @When I make a request for products
     */
    public function iMakeARequestForProducts(): void
    {
        $application = new Application(
            new HtmlProductRepository(
                new HtmlProductParser(),
                new ProductCollectionFactory(),
                $this->productSource,
            )
        )
        ;
        $command = new ListProductsCommand($application);

        $symfonyApplication = new SymfonyApplication();
        $symfonyApplication->add($command);
        $sut = $symfonyApplication->find('wireless-logic:list-products');
        $commandTester = new CommandTester($sut);

        $this->result = $commandTester->execute([]);
        $this->output = trim($commandTester->getDisplay());
    }

    /**
     * @Then I should receive a list of products ordered by most expensive monthly cost first
     */
    public function iShouldReceiveAListOfProductsOrderedByMostExpensiveMonthlyCostFirst(): void
    {
        \assert($this->result === Command::SUCCESS);
        \assert($this->output === '[{"title":"Optimum: 2 GB Data - 12 Months","description":"2GB data per monthincluding 40 SMS(5p / minute and 4p / SMS thereafter)","annualPrice":19188,"discount":0,"subscriptionType":"Monthly"},{"title":"Optimum: 24GB Data - 1 Year","description":"Up to 12GB of data per year including 480 SMS(5p / MB data and 4p / SMS thereafter)","annualPrice":17400,"discount":1788,"subscriptionType":"Annual"},{"title":"Standard: 1GB Data - 12 Months","description":"Up to 1 GB data per monthincluding 35 SMS(5p / MB data and 4p / SMS thereafter)","annualPrice":11988,"discount":0,"subscriptionType":"Monthly"},{"title":"Standard: 12GB Data - 1 Year","description":"Up to 12GB of data per year including 420 SMS(5p / MB data and 4p / SMS thereafter)","annualPrice":10800,"discount":1188,"subscriptionType":"Annual"},{"title":"Basic: 500MB Data - 12 Months","description":"Up to 500MB of data per monthincluding 20 SMS(5p / MB data and 4p / SMS thereafter)","annualPrice":7188,"discount":0,"subscriptionType":"Monthly"},{"title":"Basic: 6GB Data - 1 Year","description":"Up to 6GB of data per yearincluding 240 SMS(5p / MB data and 4p / SMS thereafter)","annualPrice":6600,"discount":588,"subscriptionType":"Annual"}]');
    }

    /**
     * @When I make a bad request for products
     */
    public function iMakeABadRequestForProducts(): void
    {
        $application = new Application(
            new HtmlProductRepository(
                new HtmlProductParser(),
                new ProductCollectionFactory(),
                'https://bad-source',
            )
        )
        ;
        $command = new ListProductsCommand($application);

        $symfonyApplication = new SymfonyApplication();
        $symfonyApplication->add($command);
        $sut = $symfonyApplication->find('wireless-logic:list-products');
        $commandTester = new CommandTester($sut);

        $this->result = $commandTester->execute([]);
        $this->output = trim($commandTester->getDisplay());
    }

    /**
     * @Then I should receive an appropriate error message
     */
    public function iShouldReceiveAnAppropriateErrorMessage(): void
    {
        \assert($this->result === Command::FAILURE);
        \assert(str_contains($this->output, 'Failed to fetch the product data from https://bad-source because: Warning:'));
    }
}
