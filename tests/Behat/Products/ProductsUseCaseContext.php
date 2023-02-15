<?php

declare(strict_types=1);

namespace WirelessLogic\Tests\Behat\Products;

use Behat\Behat\Context\Context;
use Doctrine\Common\Collections\Collection;
use WirelessLogic\Application\Application;
use WirelessLogic\Domain\Products\HtmlProductParser;
use WirelessLogic\Domain\Products\Product;
use WirelessLogic\Domain\Products\ProductCollectionFactory;
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
        $productCount = $this->products->count();

        \assert($productCount === 6);

        for ($i = 0; $i < $productCount - 1; $i++) {
            $currentProduct = $this->products->current();
            \assert($currentProduct instanceof Product);
            $nextProduct = $this->products->next();
            \assert($nextProduct instanceof Product);

            \assert($currentProduct->annualPrice() >= $nextProduct->annualPrice());
        }
    }
}
