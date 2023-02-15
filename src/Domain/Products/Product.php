<?php

declare(strict_types=1);

namespace WirelessLogic\Domain\Products;

class Product
{
    private function __construct(
        private readonly string $title,
        private readonly string $description,
        private readonly int $annualPrice,
        private readonly int $discount,
        private readonly SubscriptionType $subscriptionType
    ) {
    }

    public static function monthlySubscription(
        string $title,
        string $description,
        int $monthlyPrice,
    ) : self {
        return new self($title, $description, $monthlyPrice * 12, 0, SubscriptionType::MONTHLY);
    }

    public static function annualSubscription(
        string $title,
        string $description,
        int $annualPrice,
        int $discount,
    ) : self {
        return new self($title, $description, $annualPrice, $discount, SubscriptionType::ANNUAL);
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

    /**
     * @return array<string, int|string|SubscriptionType>
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'annualPrice' => $this->annualPrice,
            'discount' => $this->discount,
            'subscriptionType' => $this->subscriptionType,
        ];
    }
}
