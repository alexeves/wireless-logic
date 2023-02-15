<?php

declare(strict_types=1);

namespace WirelessLogic\Domain\Products;

class CouldNotListHtmlProducts extends \RuntimeException implements CouldNotListProducts
{
    public static function becauseProductDataCouldNotBeFetchedFrom(string $source, string $message): self
    {
        $message = \sprintf('Failed to fetch the product data from %s because: %s', $source, $message);

        return new self($message);
    }

    public static function becauseProductDataCouldNotBeParsed(string $message): self
    {
        $message = \sprintf('Failed to parse the product data from the source because: %s', $message);

        return new self($message);
    }

    public static function becauseNodeNotFoundWithXpath(string $message): self
    {
        $message = \sprintf('Failed to parse the product data from the source because: %s', $message);

        return new self($message);
    }
}
