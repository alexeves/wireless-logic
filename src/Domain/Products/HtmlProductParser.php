<?php

declare(strict_types=1);

namespace WirelessLogic\Domain\Products;

class HtmlProductParser
{
    /**
     * @return array<int, array<string, int|string|SubscriptionType|null>>
     */
    public function parse(string $html): array
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        try {
            $nodeList = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), 'package ')]");
        } catch (\Throwable $throwable) {
            throw CouldNotListHtmlProducts::becauseProductDataCouldNotBeParsed($throwable->getMessage());
        }

        \assert($nodeList instanceof \DOMNodeList);
        $nodeListIterator = $nodeList->getIterator();
        $products = [];

        /* @var \DOMElement $element */
        foreach ($nodeListIterator as $element) {
            $innerDom = new \DOMDocument();
            $cloned = $element->cloneNode(true);
            $innerDom->appendChild($innerDom->importNode($cloned, true));
            $xpath = new \DOMXPath($innerDom);

            $product = [];

            $product['title'] = $this->extractNodeValueFromXpath('//*[contains(concat(" ", normalize-space(@class), " "), "header ")]//h3', $xpath);
            $product['description'] = $this->extractNodeValueFromXpath('//*[@class="package-description"]', $xpath);
            $rawPrice = $this->extractNodeValueFromXpath('//*[@class="price-big"]', $xpath);
            $product['price'] = (int) \preg_replace('/\D/', '', $rawPrice);

            $product['subscriptionType'] = \str_contains(\strtolower($product['title']), 'year') ?
                SubscriptionType::ANNUAL :
                SubscriptionType::MONTHLY
            ;

            $products[] = $product;
        }

        return $products;
    }

    private function extractNodeValueFromXpath(string $xpathQuery, \DOMXPath $xpath): string
    {
        try {
            $nodeList = $xpath->query($xpathQuery);
        } catch (\Throwable $throwable) {
            throw CouldNotListHtmlProducts::becauseProductDataCouldNotBeParsed($throwable->getMessage());
        }

        if (!$nodeList instanceof \DOMNodeList || $nodeList->item(0) === null) {
            throw CouldNotListHtmlProducts::becauseNodeNotFoundWithXpath($xpathQuery);
        }

        \assert(\is_string($nodeList->item(0)->nodeValue));

        return $nodeList->item(0)->nodeValue;
    }
}
