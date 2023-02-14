<?php

declare(strict_types=1);

namespace WirelessLogic\Domain\Products;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ProductCollectionFactory
{
    /**
     * @return Collection<Product>
     */
    public function createFromArray(array $productsArray): Collection
    {
        $products = new ArrayCollection();
        foreach ($productsArray['monthly'] as $productArray) {
            $price = $this->extractPrice($productArray['price']);

            $product = Product::monthlySubscription(
                $productArray['title'],
                $productArray['description'],
                $price,
            );

            $products->add($product);
        }

        foreach ($productsArray['annual'] as $productArray) {
            $price = $this->extractPrice($productArray['price']);
            $discount = $this->calculateDiscount($products, $productArray['title'], $price);

            $product = Product::annualSubscription(
                $productArray['title'],
                $productArray['description'],
                $price,
                $discount,
            );

            $products->add($product);
        }

        return $products;
    }

    private function extractPrice(string $priceString): int
    {
        $price = (float)\str_replace('£', '', $priceString);
        $price = $price * 100;

        return (int)$price;
    }

    private function calculateDiscount(ArrayCollection $products, string $productTitle, int $price)
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
