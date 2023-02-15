<?php

declare(strict_types=1);

namespace WirelessLogic\Application;

use Doctrine\Common\Collections\Collection;
use WirelessLogic\Domain\Products\Product;
use WirelessLogic\Domain\Products\ProductRepository;

class Application
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    /**
     * @return Collection<int, Product>
     */
    public function listProducts(): Collection
    {
        return $this->productRepository->findAllProductsOrderedByAnnualPriceDescending();
    }
}
