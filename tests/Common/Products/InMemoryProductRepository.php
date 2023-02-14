<?php

declare(strict_types=1);

namespace WirelessLogic\Tests\Common\Products;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use WirelessLogic\Domain\Products\Product;
use WirelessLogic\Domain\Products\ProductCollectionFactory;
use WirelessLogic\Domain\Products\ProductRepository;

class InMemoryProductRepository implements ProductRepository
{
    public function __construct(private readonly ProductCollectionFactory $productCollectionFactory)
    {
    }

    public function findAllProductsOrderedByAnnualPriceDescending(): Collection
    {
        $productData = [
            'monthly' => [
                [
                    'title' => 'Basic: 500MB Data - 12 Months',
                    'description' => 'Up to 500MB',
                    'price' => '£5.99',
                ],
                [
                    'title' => 'Standard: 1GB Data - 12 Months',
                    'description' => 'Up to 1GB',
                    'price' => '£9.99',
                ],
                [
                    'title' => 'Optimum: 2GB Data - 12 Months',
                    'description' => 'Up to 2GB',
                    'price' => '£15.99',
                ],
            ],
            'annual' => [
                [
                    'title' => 'Basic: 6GB Data - 1 Year',
                    'description' => 'Up to 6GB',
                    'price' => '£66.00',
                ],
                [
                    'title' => 'Standard: 12GB Data - 1 Year',
                    'description' => 'Up to 12GB',
                    'price' => '£108.00',
                ],
                [
                    'title' => 'Optimum: 24GB Data - 1 Year',
                    'description' => 'Up to 24GB',
                    'price' => '174.00',
                ],
            ],
        ];

        $products = $this->productCollectionFactory->createFromArray($productData)->toArray();

        \usort(
            $products,
            function (Product $a, Product $b): int {
                return ($a->annualPrice() > $b->annualPrice()) ? -1 : 1;
            },
        );

        return new ArrayCollection($products);
    }
}
