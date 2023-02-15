<?php

declare(strict_types=1);

namespace WirelessLogic\Infrastructure\Products;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use WirelessLogic\Domain\Products\HtmlProductParser;
use WirelessLogic\Domain\Products\Product;
use WirelessLogic\Domain\Products\ProductCollectionFactory;
use WirelessLogic\Domain\Products\CouldNotListHtmlProducts;
use WirelessLogic\Domain\Products\ProductRepository;

class HtmlProductRepository implements ProductRepository
{
    public function __construct(
        private readonly HtmlProductParser $htmlProductParser,
        private readonly ProductCollectionFactory $productCollectionFactory,
        private readonly string $productSource,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function findAllProductsOrderedByAnnualPriceDescending(): Collection
    {
        try {
            $html = \file_get_contents($this->productSource);
        } catch (\Throwable $throwable) {
            throw CouldNotListHtmlProducts::becauseProductDataCouldNotBeFetchedFrom($this->productSource, $throwable->getMessage());
        }

        \assert(\is_string($html));
        $productData = $this->htmlProductParser->parse($html);
        $products = $this->productCollectionFactory->createFromArray($productData)->toArray();

        \usort(
            $products,
            function (Product $a, Product $b): int {
                return ($a->annualPrice() > $b->annualPrice()) ? -1 : 1;
            },
        );

        return new ArrayCollection($products);
    }
}
