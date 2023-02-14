<?php

declare(strict_types=1);

namespace WirelessLogic\Domain\Products;

class Product
{
    private readonly SubscriptionType $subscriptionType;

    private readonly int $annualPrice;

    private readonly int $discount;

    private function __construct(
        private readonly string $title,
        private readonly string $description,
    ) {
    }

    public static function monthlySubscription(
        string $title,
        string $description,
        int $monthlyPrice,
    ) : self {
        $instance = new self($title, $description);
        $instance->subscriptionType = SubscriptionType::MONTHLY;
        $instance->annualPrice = $monthlyPrice * 12;
        $instance->discount = 0;

        return $instance;
    }

    public static function annualSubscription(
        string $title,
        string $description,
        int $annualPrice,
        int $discount,
    ) : self {
        $instance = new self($title, $description);
        $instance->subscriptionType = SubscriptionType::ANNUAL;
        $instance->annualPrice = $annualPrice;
        $instance->discount = $discount;

        return $instance;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function annualPrice(): int
    {
        return $this->annualPrice;
    }

    public function discount(): int
    {
        return $this->discount;
    }

    public function subscriptionType(): SubscriptionType
    {
        return $this->subscriptionType;
    }

    public function isMonthlySubscription(): bool
    {
        return $this->subscriptionType === SubscriptionType::MONTHLY;
    }
}
