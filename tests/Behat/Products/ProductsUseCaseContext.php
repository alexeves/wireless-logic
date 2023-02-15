<?php

declare(strict_types=1);

namespace WirelessLogic\Tests\Behat\Products;

use Behat\Behat\Context\Context;
use Doctrine\Common\Collections\Collection;
use WirelessLogic\Application\Application;
use WirelessLogic\Domain\Products\HtmlProductParser;
use WirelessLogic\Domain\Products\Product;
use WirelessLogic\Domain\Products\ProductCollectionFactory;
use WirelessLogic\Domain\Products\SubscriptionType;
use WirelessLogic\Tests\Common\Products\InMemoryProductRepository;

final class ProductsUseCaseContext implements Context
{
    /**
     * @var Collection<int, Product>
     */
    private Collection $products;

    /**
     * @When I make a request for products
     */
    public function iMakeARequestForProducts(): void
    {
        $application = new Application(new InMemoryProductRepository(new HtmlProductParser(), new ProductCollectionFactory()));
        $this->products = $application->listProducts();
    }

    /**
     * @Then I should receive a list of products ordered by most expensive monthly cost first
     */
    public function iShouldReceiveAListOfProductsOrderedByMostExpensiveMonthlyCostFirst(): void
    {
        \assert($this->products->count() === 6);

        $productOne = $this->products->current();
        \assert($productOne instanceof Product);
        \assert($productOne->title() === 'Optimum: 2GB Data - 12 Months');
        \assert($productOne->description() === '2GB data per month including 40 SMS (5p / minute and 4p / SMS thereafter)');
        \assert($productOne->annualPrice() === 19188);
        \assert($productOne->discount() === 0);
        \assert($productOne->subscriptionType() === SubscriptionType::MONTHLY);

        $productTwo = $this->products->next();
        \assert($productTwo instanceof Product);
        \assert($productTwo->title() === 'Optimum: 24GB Data - 1 Year');
        \assert($productTwo->description() === 'Up to 24GB of data per year including 480 SMS (5p / MB data and 4p / SMS thereafter)');
        \assert($productTwo->annualPrice() === 17400);
        \assert($productTwo->discount() === 1788);
        \assert($productTwo->subscriptionType() === SubscriptionType::ANNUAL);

        $productThree = $this->products->next();
        \assert($productThree instanceof Product);
        \assert($productThree->title() === 'Standard: 1GB Data - 12 Months');
        \assert($productThree->description() === 'Up to 1GB data per month including 35 SMS (5p / MB data and 4p / SMS thereafter)');
        \assert($productThree->annualPrice() === 11988);
        \assert($productThree->discount() === 0);
        \assert($productThree->subscriptionType() === SubscriptionType::MONTHLY);

        $productFour = $this->products->next();
        \assert($productFour instanceof Product);
        \assert($productFour->title() === 'Standard: 12GB Data - 1 Year');
        \assert($productFour->description() === 'Up to 12GB of data per year including 420 SMS (5p / MB data and 4p / SMS thereafter)');
        \assert($productFour->annualPrice() === 10800);
        \assert($productFour->discount() === 1188);
        \assert($productFour->subscriptionType() === SubscriptionType::ANNUAL);

        $productFive = $this->products->next();
        \assert($productFive instanceof Product);
        \assert($productFive->title() === 'Basic: 500MB Data - 12 Months');
        \assert($productFive->description() === 'Up to 500MB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)');
        \assert($productFive->annualPrice() === 7188);
        \assert($productFive->discount() === 0);
        \assert($productFive->subscriptionType() === SubscriptionType::MONTHLY);

        $productSix = $this->products->next();
        \assert($productSix instanceof Product);
        \assert($productSix->title() === 'Basic: 6GB Data - 1 Year');
        \assert($productSix->description() === 'Up to 6GB of data per year including 240 SMS (5p / MB data and 4p / SMS thereafter)');
        \assert($productSix->annualPrice() === 6600);
        \assert($productSix->discount() === 588);
        \assert($productSix->subscriptionType() === SubscriptionType::ANNUAL);
    }
}
