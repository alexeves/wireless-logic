<?php

declare(strict_types=1);

namespace WirelessLogic\Tests\PHPUnit\Domain\Products;

use PHPUnit\Framework\TestCase;
use WirelessLogic\Domain\Products\Product;
use WirelessLogic\Domain\Products\SubscriptionType;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function it_calculates_the_annual_price_for_a_monthly_subscription(): void
    {
        $product = Product::monthlySubscription('title', 'description', 100);

        $this->assertEquals(1200, $product->annualPrice());
    }

    /**
     * @test
     */
    public function it_sets_the_discount_to_zero_for_a_monthly_subscription(): void
    {
        $product = Product::monthlySubscription('title', 'description', 100);

        $this->assertEquals(0, $product->discount());
    }

    /**
     * @test
     */
    public function it_assigns_the_annual_price_for_an_annual_subscription(): void
    {
        $product = Product::annualSubscription('title', 'description', 1000, 9);

        $this->assertEquals(1000, $product->annualPrice());
    }

    /**
     * @test
     */
    public function it_assigns_the_discount_for_an_annual_subscription(): void
    {
        $product = Product::annualSubscription('title', 'description', 100, 9);

        $this->assertEquals(9, $product->discount());
    }

    /**
     * @test
     */
    public function it_sets_the_subscription_type_for_a_monthly_subscription(): void
    {
        $product = Product::monthlySubscription('title', 'description', 100);

        $this->assertEquals(SubscriptionType::MONTHLY, $product->subscriptionType());
    }

    /**
     * @test
     */
    public function it_sets_the_subscription_type_for_an_annual_subscription(): void
    {
        $product = Product::annualSubscription('title', 'description', 100, 9);

        $this->assertEquals(SubscriptionType::ANNUAL, $product->subscriptionType());
    }
}
