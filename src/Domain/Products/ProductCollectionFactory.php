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
            $product = Product::monthlySubscription(
                $productArray['title'],
                $productArray['description'],
                $productArray['price'],
            );

            $products->add($product);
        }

        foreach ($productsArray['annually'] as $productArray) {
            $discount = $this->calculateDiscount($products, $productArray['title'], $productArray['price']);

            $product = Product::annualSubscription(
                $productArray['title'],
                $productArray['description'],
                $productArray['price'],
                $discount,
            );

            $products->add($product);
        }

        return $products;
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
