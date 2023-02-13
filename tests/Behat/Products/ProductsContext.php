<?php

declare(strict_types=1);

namespace WirelessLogic\Tests\Behat\Products;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class ProductsContext implements Context
{
    /**
     * @When I make a request for products
     */
    public function iMakeARequestForProducts()
    {
        throw new PendingException();
    }

    /**
     * @Then I should receive a list of products ordered by most expensive monthly cost first
     */
    public function iShouldReceiveAListOfProductsOrderedByMostExpensiveMonthlyCostFirst()
    {
        throw new PendingException();
    }

}
