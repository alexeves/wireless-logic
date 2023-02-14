<?php

declare(strict_types=1);

namespace WirelessLogic\Domain\Products;

use Doctrine\Common\Collections\Collection;

interface ProductRepository
{
    public function findAllProductsOrderedByAnnualPriceDescending(): Collection;
}
