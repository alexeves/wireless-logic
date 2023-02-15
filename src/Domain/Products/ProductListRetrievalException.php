<?php

declare(strict_types=1);

namespace WirelessLogic\Domain\Products;

class ProductListRetrievalException extends \RuntimeException
{
    public static function becauseProductDataCouldNotBeFetched(?string $message = null): self
    {
        if ($message === null) {
            $message = 'Failed to fetch the product data from the source';
        }

        return new self($message);
    }
}
