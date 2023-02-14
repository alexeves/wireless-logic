<?php

declare(strict_types=1);

namespace WirelessLogic\Tests\PHPUnit\Domain\Products;

use PHPUnit\Framework\TestCase;
use WirelessLogic\Domain\Products\ProductCollectionFactory;

class ProductCollectionFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_a_collection_of_products(): void
    {
        $sut = new ProductCollectionFactory();
        $products = $sut->createFromArray(
            [
                'monthly' => [
                    [
                        'title' => 'Basic: 500MB Data - 12 Months',
                        'description' => 'Up to 500MB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)',
                        'price' => 599,
                    ],
                    [
                        'title' => 'Standard: 1GB Data - 12 Months',
                        'description' => 'Up to 1GB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)',
                        'price' => 999,
                    ],
                ],
                'annually' => [
                    [
                        'title' => 'Basic: 6GB Data - 1 Year',
                        'description' => 'Up to 6GB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)',
                        'price' => 6600,
                    ],
                ],
            ],
        );

        $this->assertCount(3, $products);
    }
}
