<?php

declare(strict_types=1);

namespace WirelessLogic\Tests\PHPUnit\Integration\Products;

use PHPUnit\Framework\TestCase;
use WirelessLogic\Domain\Products\HtmlProductParser;
use WirelessLogic\Domain\Products\Product;
use WirelessLogic\Domain\Products\ProductCollectionFactory;
use WirelessLogic\Domain\Products\ProductRepository;
use WirelessLogic\Infrastructure\Products\HtmlProductRepository;
use WirelessLogic\Tests\Common\Products\InMemoryProductRepository;

class ProductRepositoryContractTest extends TestCase
{
    /**
     * @test
     * @dataProvider productRepositories
     */
    public function it_can_return_an_ordered_collection_of_products(ProductRepository $productRepository): void
    {
        $products = $productRepository->findAllProductsOrderedByAnnualPriceDescending();
        $productCount = $products->count();

        for ($i = 0; $i < $productCount - 1; $i++) {
            $currentProduct = $products->current();
            \assert($currentProduct instanceof Product);
            $nextProduct = $products->next();
            \assert($nextProduct instanceof Product);

            $this->assertTrue($currentProduct->annualPrice() >= $nextProduct->annualPrice());
        }
    }

    public function productRepositories(): iterable
    {
        yield [new InMemoryProductRepository(new HtmlProductParser(), new ProductCollectionFactory())];
        yield [new HtmlProductRepository(new HtmlProductParser(), new ProductCollectionFactory())];
    }
}
