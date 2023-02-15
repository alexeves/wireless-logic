<?php

declare(strict_types=1);

namespace WirelessLogic\Tests\PHPUnit\Domain\Products;

use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use WirelessLogic\Domain\Products\Product;
use WirelessLogic\Domain\Products\ProductCollectionFactory;
use WirelessLogic\Domain\Products\SubscriptionType;

class ProductCollectionFactoryTest extends TestCase
{
    private ProductCollectionFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new ProductCollectionFactory();
    }

    /**
     * @test
     */
    public function it_returns_an_empty_collection_if_given_empty_product_data(): void
    {
        $products = $this->sut->createFromArray([]);
        $this->assertInstanceOf(Collection::class, $products);
        $this->assertCount(0, $products);
    }

    /**
     * @test
     */
    public function it_returns_a_collection_of_products_when_given_some_product_data(): void
    {
        $sut = new ProductCollectionFactory();
        $products = $sut->createFromArray([
            [
                'title' => 'Basic: 500MB Data - 12 Months',
                'description' => 'Up to 500MB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)',
                'price' => 599,
                'subscriptionType' => SubscriptionType::MONTHLY,
            ],
            [
                'title' => 'Basic: 6GB Data - 1 Year',
                'description' => 'Up to 6GB of data per year including 20 SMS (5p / MB data and 4p / SMS thereafter)',
                'price' => 6600,
                'subscriptionType' => SubscriptionType::ANNUAL,
            ],
            [
                'title' => 'Standard: 1GB Data - 12 Months',
                'description' => 'Up to 1GB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)',
                'price' => 999,
                'subscriptionType' => SubscriptionType::MONTHLY,
            ],
        ]);

        $this->assertCount(3, $products);

        $monthlyProduct = $products->first();
        \assert($monthlyProduct instanceof Product);
        $this->assertEquals('Basic: 500MB Data - 12 Months', $monthlyProduct->title());
        $this->assertEquals('Up to 500MB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)', $monthlyProduct->description());
        $this->assertEquals(7188, $monthlyProduct->annualPrice());
        $this->assertEquals(0, $monthlyProduct->discount());
        $this->assertEquals(SubscriptionType::MONTHLY, $monthlyProduct->subscriptionType());

        $annualProduct = $products->last();
        \assert($annualProduct instanceof Product);
        $this->assertEquals('Basic: 6GB Data - 1 Year', $annualProduct->title());
        $this->assertEquals('Up to 6GB of data per year including 20 SMS (5p / MB data and 4p / SMS thereafter)', $annualProduct->description());
        $this->assertEquals(6600, $annualProduct->annualPrice());
        $this->assertEquals(588, $annualProduct->discount());
        $this->assertEquals(SubscriptionType::ANNUAL, $annualProduct->subscriptionType());
    }

    /**
     * @param array<int, array<string, int|string|SubscriptionType>> $productData
     * @test
     * @dataProvider provideUnexpectedProductData
     */
    public function it_throws_an_exception_if_the_given_product_data_is_not_in_the_expected_format(mixed $productData): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Could not create Product Collection. The given product data is not in expected format');
        $this->sut->createFromArray($productData);
    }

    /**
     * @return array<mixed>
     */
    public function provideUnexpectedProductData(): iterable
    {
        yield [['not-an-array']];

        yield [
            [
                [
                'description' => 'Up to 500MB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)',
                'price' => 599,
                'subscriptionType' => SubscriptionType::MONTHLY,
                ]
            ]
        ];

        yield [
            [
                [
                    'title' => 12,
                    'description' => 'Up to 500MB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)',
                    'price' => 599,
                    'subscriptionType' => SubscriptionType::MONTHLY,
                ]
            ]
        ];

        yield [
            [
                [
                    'title' => 'Basic: 500MB Data - 12 Months',
                    'price' => 599,
                    'subscriptionType' => SubscriptionType::MONTHLY,
                ]
            ]
        ];

        yield [
            [
                [
                    'title' => 'Basic: 500MB Data - 12 Months',
                    'description' => 34,
                    'price' => 599,
                    'subscriptionType' => SubscriptionType::MONTHLY,
                ]
            ]
        ];

        yield [
            [
                [
                    'title' => 'Basic: 500MB Data - 12 Months',
                    'description' => 'Up to 500MB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)',
                    'subscriptionType' => SubscriptionType::MONTHLY,
                ]
            ]
        ];

        yield [
            [
                [
                    'title' => 'Basic: 500MB Data - 12 Months',
                    'description' => 'Up to 500MB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)',
                    'price' => '599',
                    'subscriptionType' => SubscriptionType::MONTHLY,
                ]
            ]
        ];

        yield [
            [
                [
                    'title' => 'Basic: 500MB Data - 12 Months',
                    'description' => 'Up to 500MB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)',
                    'price' => 599,
                ]
            ]
        ];

        yield [
            [
                [
                    'title' => 'Basic: 500MB Data - 12 Months',
                    'description' => 'Up to 500MB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)',
                    'price' => 599,
                    'subscriptionType' => 'Monthly',
                ]
            ]
        ];
    }
}
