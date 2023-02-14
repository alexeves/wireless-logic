<?php

declare(strict_types=1);

namespace WirelessLogic\Tests\Common\Products;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use WirelessLogic\Domain\Products\Product;
use WirelessLogic\Domain\Products\ProductRepository;

class InMemoryProductRepository implements ProductRepository
{
    public function findAllProductsOrderedByAnnualPriceDescending(): Collection
    {
        $products = new ArrayCollection();
        $products->add(Product::monthlySubscription('Optimum 2GB', 'Optimum 2GB per month', 1599));
        $products->add(Product::annualSubscription('Optimum 24GB', 'Optimum 24GB per year', 17400, 1788));
        $products->add(Product::monthlySubscription('Standard 1GB', 'Standard 1GB per month', 999));
        $products->add(Product::annualSubscription('Standard 12GB', 'Standard 12GB per year', 10800, 1188));
        $products->add(Product::monthlySubscription('Basic 500MB', 'Basic 500MB per month', 599));
        $products->add(Product::annualSubscription('Basic 6GB', 'Basic 6GB per year', 6600, 588));
        
        return $products;
    }
}
