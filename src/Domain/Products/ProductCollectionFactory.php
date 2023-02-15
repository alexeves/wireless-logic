<?php

declare(strict_types=1);

namespace WirelessLogic\Domain\Products;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ProductCollectionFactory
{
    /**
     * @param array<int, array<string, int|string|SubscriptionType>> $productsData
     * @return Collection<int, Product>
     */
    public function createFromArray(array $productsData): Collection
    {
        if (empty($productsData)) {
            return new ArrayCollection();
        }

        if (!$this->isProductDataInExpectedFormat($productsData)) {
            throw new \InvalidArgumentException('Could not create Product Collection. The given product data is not in expected format');
        }

        $sortedProductsData = $this->sortProductsArrayIntoMonthlySubscriptionsFirst($productsData);

        return $this->createProductCollection($sortedProductsData);
    }

    /**
     * @param array<int, array<string, int|string|SubscriptionType>> $products
     */
    private function isProductDataInExpectedFormat(array $products): bool
    {
        foreach ($products as $product) {
            if (!\is_array($product)) {
                return false;
            }

            if (!isset($product['title']) || !\is_string($product['title'])) {
                return false;
            }

            if (!isset($product['description']) || !\is_string($product['description'])) {
                return false;
            }

            if (!isset($product['price']) || !\is_integer($product['price'])) {
                return false;
            }

            if (!isset($product['subscriptionType']) || !$product['subscriptionType'] instanceof SubscriptionType) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array<int, array<string, int|string|SubscriptionType>> $productsData
     * @return array<int, array<string, int|string|SubscriptionType>>
     */
    private function sortProductsArrayIntoMonthlySubscriptionsFirst(array $productsData): array
    {
        \usort($productsData, function (array $a, array $b): int {
            $currentSubscriptionType = $a['subscriptionType'];
            $nextSubscriptionType = $b['subscriptionType'];

            if ($currentSubscriptionType === $nextSubscriptionType) {
                return 0;
            }

            return $currentSubscriptionType === SubscriptionType::MONTHLY ? -1 : 1;
        });

        return $productsData;
    }

    /**
     * @param array<int, array<string, int|string|SubscriptionType>> $productsData
     * @return Collection<int, Product>
     */
    private function createProductCollection(array $productsData): Collection
    {
        $productCollection = new ArrayCollection();

        foreach ($productsData as $productData) {
            \assert(\is_string($productData['title']));
            \assert(\is_string($productData['description']));
            \assert(\is_integer($productData['price']));
            \assert($productData['subscriptionType'] instanceof SubscriptionType);

            if ($productData['subscriptionType'] === SubscriptionType::MONTHLY) {
                $productCollection->add(Product::monthlySubscription(
                    $productData['title'],
                    $productData['description'],
                    $productData['price'],
                ));

                continue;
            }

            $discount = $this->calculateDiscount($productCollection, $productData['title'], $productData['price']);

            $productCollection->add(Product::annualSubscription(
                $productData['title'],
                $productData['description'],
                $productData['price'],
                $discount,
            ));
        }

        return $productCollection;
    }

    /**
     * @param Collection<int, Product> $products
     */
    private function calculateDiscount(Collection $products, string $productTitle, int $price): int
    {
        $correspondingMonthlyProduct = $products->filter(function (Product $product) use ($productTitle) {
            if (!$product->isMonthlySubscription()) {
                return false;
            }

            $productTypeOfMonthlyProduct = \strtok($product->title(), ':');
            $productTypeOfThisProduct = \strtok($productTitle, ':');

            return $productTypeOfMonthlyProduct === $productTypeOfThisProduct;
        })->first();

        \assert($correspondingMonthlyProduct instanceof Product);

        return $correspondingMonthlyProduct->annualPrice() - $price;
    }
}
