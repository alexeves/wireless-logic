<?php

declare(strict_types=1);

namespace WirelessLogic\Tests\Behat\Products;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Doctrine\Common\Collections\Collection;
use WirelessLogic\Application\Application;
use WirelessLogic\Application\Products\ProductsQuery;
use WirelessLogic\Domain\Products\Product;
use WirelessLogic\Domain\Products\SubscriptionType;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class ProductsContext implements Context
{
    /**
     * @var Collection<Product>
     */
    private Collection $products;

    public function __construct(private readonly Application $application)
    {}

    /**
     * @When I make a request for products
     */
    public function iMakeARequestForProducts()
    {
        $this->products = $this->application->listProducts(new ProductsQuery());
    }

    /**
     * @Then I should receive a list of products ordered by most expensive monthly cost first
     */
    public function iShouldReceiveAListOfProductsOrderedByMostExpensiveMonthlyCostFirst()
    {
        \assert($this->products->count() === 6);

        $productOne = $this->products->current();
        \assert($productOne instanceof Product);
        \assert($productOne->title() === 'Optimum 2GB');
        \assert($productOne->description() === 'Optimum 2GB per month');
        \assert($productOne->annualPrice() === 19188);
        \assert($productOne->discount() === 0);
        \assert($productOne->subscriptionType() === SubscriptionType::MONTHLY);

        $productTwo = $this->products->next();
        \assert($productTwo instanceof Product);
        \assert($productTwo->title() === 'Optimum 24GB');
        \assert($productTwo->description() === 'Optimum 24GB per year');
        \assert($productTwo->annualPrice() === 17400);
        \assert($productTwo->discount() === 1788);
        \assert($productTwo->subscriptionType() === SubscriptionType::ANNUAL);

        $productThree = $this->products->next();
        \assert($productThree instanceof Product);
        \assert($productThree->title() === 'Standard 1GB');
        \assert($productThree->description() === 'Standard 1GB per month');
        \assert($productThree->annualPrice() === 11988);
        \assert($productThree->discount() === 0);
        \assert($productThree->subscriptionType() === SubscriptionType::MONTHLY);

        $productFour = $this->products->next();
        \assert($productFour instanceof Product);
        \assert($productFour->title() === 'Standard 12GB');
        \assert($productFour->description() === 'Standard 12GB per year');
        \assert($productFour->annualPrice() === 10800);
        \assert($productFour->discount() === 1188);
        \assert($productFour->subscriptionType() === SubscriptionType::ANNUAL);

        $productFive = $this->products->next();
        \assert($productFive instanceof Product);
        \assert($productFive->title() === 'Basic 500MB');
        \assert($productFive->description() === 'Basic 500MB per month');
        \assert($productFive->annualPrice() === 7188);
        \assert($productFive->discount() === 0);
        \assert($productFive->subscriptionType() === SubscriptionType::MONTHLY);

        $productSix = $this->products->next();
        \assert($productSix instanceof Product);
        \assert($productSix->title() === 'Basic 6GB');
        \assert($productSix->description() === 'Basic 6GB per year');
        \assert($productSix->annualPrice() === 6600);
        \assert($productSix->discount() === 588);
        \assert($productSix->subscriptionType() === SubscriptionType::ANNUAL);
    }
}
