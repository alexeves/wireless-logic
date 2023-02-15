<?php

declare(strict_types=1);

namespace WirelessLogic\Domain\Products;

class HtmlProductParser
{
    /**
     * @return array<int, array<string, int|string|SubscriptionType>>
     */
    public function parse(string $html): array
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);
        $elements = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), 'package ')]");
        \assert($elements instanceof \DOMNodeList);

        $elementsIterator = $elements->getIterator();
        $products = [];

        /* @var \DOMElement $element */
        foreach ($elementsIterator as $element) {
            $innerDom = new \DOMDocument();
            $cloned = $element->cloneNode(true);
            $innerDom->appendChild($innerDom->importNode($cloned, true));
            $xpath = new \DOMXPath($innerDom);

            $product = [];
            $titleNodeList = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), 'header ')]//h3");
            \assert($titleNodeList instanceof \DOMNodeList);
            $product['title'] = $titleNodeList->item(0)?->nodeValue;
            \assert(\is_string($product['title']));

            $descriptionNodeList = $xpath->query("//*[@class='package-description']");
            \assert($descriptionNodeList instanceof \DOMNodeList);
            $product['description'] = $descriptionNodeList->item(0)?->nodeValue;
            \assert(\is_string($product['description']));

            $price = $xpath->query("//*[@class='price-big']");
            \assert($price instanceof \DOMNodeList);
            $rawPrice = $price->item(0)?->nodeValue;
            \assert(is_string($rawPrice));
            $product['price'] = (int) \preg_replace('/\D/', '', $rawPrice);

            $product['subscriptionType'] = \str_contains(\strtolower($product['title']), 'year') ?
                SubscriptionType::ANNUAL :
                SubscriptionType::MONTHLY
            ;

            $products[] = $product;
        }

        return $products;
    }
}
