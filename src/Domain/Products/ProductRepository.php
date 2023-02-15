<?php

declare(strict_types=1);

namespace WirelessLogic\Domain\Products;

use Doctrine\Common\Collections\Collection;

interface ProductRepository
{
    /**
     * @return Collection<int, Product>
     */
    public function findAllProductsOrderedByAnnualPriceDescending(): Collection;
}
