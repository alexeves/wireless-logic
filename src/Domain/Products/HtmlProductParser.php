<?php

declare(strict_types=1);

namespace WirelessLogic\Domain\Products;

class HtmlProductParser
{
    public function parse(string $html): array
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);
        $elements = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), 'package ')]")->getIterator();
        $products = [];

        /* @var \DOMElement $element */
        foreach ($elements as $element) {
            $innerDom = new \DOMDocument();
            $cloned = $element->cloneNode(true);
            $innerDom->appendChild($innerDom->importNode($cloned, true));
            $xpath = new \DOMXPath($innerDom);

            $product = [];
            $product['title'] = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), 'header ')]//h3")->item(0)->nodeValue;
            $product['description'] = $xpath->query("//*[@class='package-description']")->item(0)->nodeValue;
            $rawPrice = $xpath->query("//*[@class='price-big']")->item(0)->nodeValue;
            $product['price'] = (int) \preg_replace('/\D/', '', $rawPrice);

            if (\str_contains(\strtolower($product['title']), 'year')) {
                $products['annually'][] = $product;
            } else {
                $products['monthly'][] = $product;
            }
        }

        return $products;
    }
}
