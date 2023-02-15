<?php

declare(strict_types=1);

namespace WirelessLogic\Tests\PHPUnit\Integration\Products;

use PHPUnit\Framework\TestCase;
use WirelessLogic\Domain\Products\CouldNotListHtmlProducts;
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
     * @dataProvider provideProductRepositories
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

    /**
     * @return array<mixed>
     */
    public function provideProductRepositories(): iterable
    {
        yield [new InMemoryProductRepository(new HtmlProductParser(), new ProductCollectionFactory())];
        yield [new HtmlProductRepository(new HtmlProductParser(), new ProductCollectionFactory(), 'https://wltest.dns-systems.net')];
    }

    /**
     * @test
     * @dataProvider provideProductRepositoriesWithInvalidDataSource
     */
    public function it_can_throw_an_exception_if_product_data_could_not_be_fetched(ProductRepository $productRepository, string $expectedErrorMessage): void
    {
        $this->expectException(CouldNotListHtmlProducts::class);
        $this->expectExceptionMessage($expectedErrorMessage);

        $productRepository->findAllProductsOrderedByAnnualPriceDescending();
    }

    /**
     * @return array<mixed>
     */
    public function provideProductRepositoriesWithInvalidDataSource(): iterable
    {
        yield [
            'productRepository' => new HtmlProductRepository(new HtmlProductParser(), new ProductCollectionFactory(), 'https://invalid-source'),
            'expectedErrorMessage' => 'Failed to fetch the product data from https://invalid-source because: file_get_contents(): php_network_getaddresses: getaddrinfo for invalid-source failed',
        ];

        yield [
            'productRepository' => new HtmlProductRepository(new HtmlProductParser(), new ProductCollectionFactory(), 'https://wltest.dns-systems.net?bad =request'),
            'expectedErrorMessage' => 'Failed to fetch the product data from https://wltest.dns-systems.net?bad =request because: file_get_contents(https://wltest.dns-systems.net?bad =request)',
        ];
    }
}
