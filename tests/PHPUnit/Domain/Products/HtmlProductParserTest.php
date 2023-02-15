<?php

declare(strict_types=1);

namespace WirelessLogic\Tests\PHPUnit\Domain\Products;

use PHPUnit\Framework\TestCase;
use WirelessLogic\Domain\Products\HtmlProductParser;
use WirelessLogic\Domain\Products\SubscriptionType;

class HtmlProductParserTest extends TestCase
{
    /**
     * @test
     */
    public function it_parses_the_expected_html_into_an_array_of_product_data(): void
    {
        $sut = new HtmlProductParser();
        $html = '<html lang="en"><body data-container="body" class="cms-demo-home-page-english cms-index-index page-layout-1column"><div class="page-wrapper"><main id="maincontent" class="page-main"><div class="sections_wrapper"><div class="widget block block-static-block"><section id="subscriptions" class="content_section grid"><div class="row" style="margin-left:0px; margin-right:0px"><div class="top-line-decoration"></div>        <h2>Monthly Subscription Packages</h2><div class="colored-line"></div><div class="sub-heading">Choose from the packages below and get your product connected;</div><div class="pricing-table"><div class="row-subscriptions" style="margin-bottom:40px;"><div class="col-xs-4"><div class="package featured-right" style="margin-top:0px; margin-right:0px; margin-bottom:0px; margin-left:25px"><div class="header dark-bg"><h3>Basic: 500MB Data - 12 Months</h3></div><div class="package-features"><ul><li><div class="package-name">The basic starter subscription providing you with all you need to get your device up and running with inclusive Data and SMS services.</div></li><li><div class="package-description">Up to 500MB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)</div></li><li><div class="package-price"><span class="price-big">£5.99</span> (inc. VAT) Per Month</div></li><li><div class="package-data">12 Months - Data &amp; SMS Service Only</div></li></ul><div class="bottom-row"><a class="btn btn-primary main-action-button" href="https://wltest.dns-systems.net/" role="button">Choose</a></div></div></div></div> <!-- /END PACKAGE --><!-- PACKAGE TWO --><div class="col-xs-4"><div class="package featured center" style="margin-left:0px;"><div class="header dark-bg"><h3>Standard: 1GB Data - 12 Months</h3></div><div class="package-features"><ul><li><div class="package-name">The standard subscription providing you with enough service time to support the average user to enable your device to be up and running with inclusive Data and SMS services.</div></li><li><div class="package-description">Up to 1GB data per month including 35 SMS (5p / MB data and 4p / SMS thereafter)</div></li><li><div class="package-price"><span class="price-big">£9.99</span> (inc. VAT) Per Month</div></li><li><div class="package-data">12 Months - Data &amp; SMS Service Only</div></li></ul><div class="bottom-row"><a class="btn btn-primary main-action-button" href="https://wltest.dns-systems.net/" role="button">Choose</a></div></div></div></div> <!-- /END PACKAGE --><!-- PACKAGE THREE --><div class="col-cs-4"><div class="package featured-right" style="margin-top:0px; margin-left:0px; margin-bottom:0px"><div class="header dark-bg"><h3>Optimum: 2GB Data - 12 Months</h3></div><div class="package-features"><ul><li><div class="package-name">The optimum subscription providing you with enough service time to support the above-average user to enable your device to be up and running with inclusive Data and SMS services</div></li><li><div class="package-description">2GB data per month including 40 SMS (5p / minute and 4p / SMS thereafter)</div></li><li><div class="package-price"><span class="price-big">£15.99</span> (inc. VAT) Per Month</div></li><li><div class="package-data">12 Months - Data &amp; SMS Service Only</div></li></ul><div class="bottom-row"><a class="btn btn-primary main-action-button" href="https://wltest.dns-systems.net/#" role="button">Choose</a></div></div></div></div> <!-- /END PACKAGE --></div> <!-- /END ROW --></div> <!-- /END ALL PACKAGE --></div> <!-- /END CONTAINER --></section></div><div class="widget block block-static-block"><section id="subscriptions" class="content_section grid"><div class="row" style="margin-left:0px; margin-right:0px"><div class="top-line-decoration"></div>        <h2>Annual Subscription Packages</h2><div class="colored-line"></div><div class="sub-heading">Choose from the packages below and get your product connected, each with per second billing.</div><div class="pricing-table"><div class="row-subscriptions" style="margin-bottom:40px;"><div class="col-xs-4"><div class="package featured-right" style="margin-top:0px; margin-right:0px; margin-bottom:0px; margin-left:25px"><div class="header dark-bg"><h3>Basic: 6GB Data - 1 Year</h3></div><div class="package-features"><ul><li><div class="package-name">The basic starter subscription providing you with all you need to get you up and running with Data and SMS services to allow access to your device.</div></li><li><div class="package-description">Up to 6GB of data per year including 240 SMS (5p / MB data and 4p / SMS thereafter)</div></li><li><div class="package-price"><span class="price-big">£66.00</span> (inc. VAT) Per Year<p style="color: red">Save £5.86 on the monthly price</p></div></li><li><div class="package-data">Annual - Data &amp; SMS Service Only</div></li></ul><div class="bottom-row"><a class="btn btn-primary main-action-button" href="https://wltest.dns-systems.net/#" role="button">Choose</a></div></div></div></div> <!-- /END PACKAGE --><!-- PACKAGE TWO --><div class="col-xs-4"><div class="package featured center" style="margin-left:0px;"><div class="header dark-bg"><h3>Standard: 12GB Data - 1 Year</h3></div><div class="package-features"><ul><li><div class="package-name">The standard subscription providing you with enough service time to support the average user with Data and SMS services to allow access to your device.</div></li><li><div class="package-description">Up to 12GB of data per year including 420 SMS (5p / MB data and 4p / SMS thereafter)</div></li><li><div class="package-price"><span class="price-big">£108.00</span> (inc. VAT) Per Year<p style="color: red">Save £11.90 on the monthly price</p></div></li><li><div class="package-data">Annual - Data &amp; SMS Service Only</div></li></ul><div class="bottom-row"><a class="btn btn-primary main-action-button" href="https://wltest.dns-systems.net/#" role="button">Choose</a></div></div></div></div> <!-- /END PACKAGE --><!-- PACKAGE THREE --><div class="col-cs-4"><div class="package featured-right" style="margin-top:0px; margin-left:0px; margin-bottom:0px"><div class="header dark-bg"><h3>Optimum: 24GB Data - 1 Year</h3></div><div class="package-features"><ul><li><div class="package-name">The optimum subscription providing you with enough service time to support the above-average with data and SMS services to allow access to your device.</div></li><li><div class="package-description">Up to 24GB of data per year including 480 SMS (5p / MB data and 4p / SMS thereafter)</div></li><li><div class="package-price"><span class="price-big">£174.00</span> (inc. VAT) Per Year<p style="color: red">Save £17.90 on the monthly price</p></div></li><li><div class="package-data">Annual - Data &amp; SMS Service Only</div></li></ul><div class="bottom-row"><a class="btn btn-primary main-action-button" href="https://wltest.dns-systems.net/#" role="button">Choose</a></div></div></div></div> <!-- /END PACKAGE --></div> <!-- /END ROW --></div> <!-- /END ALL PACKAGE --></div> <!-- /END CONTAINER --></section></div></div></main></div></body></html>';

        $result = $sut->parse($html);

        $expected = [
            [
                'title' => 'Basic: 500MB Data - 12 Months',
                'description' => 'Up to 500MB of data per month including 20 SMS (5p / MB data and 4p / SMS thereafter)',
                'price' => 599,
                'subscriptionType' => SubscriptionType::MONTHLY,
            ],
            [
                'title' => 'Standard: 1GB Data - 12 Months',
                'description' => 'Up to 1GB data per month including 35 SMS (5p / MB data and 4p / SMS thereafter)',
                'price' => 999,
                'subscriptionType' => SubscriptionType::MONTHLY,
            ],
            [
                'title' => 'Optimum: 2GB Data - 12 Months',
                'description' => '2GB data per month including 40 SMS (5p / minute and 4p / SMS thereafter)',
                'price' => 1599,
                'subscriptionType' => SubscriptionType::MONTHLY,
            ],
            [
                'title' => 'Basic: 6GB Data - 1 Year',
                'description' => 'Up to 6GB of data per year including 240 SMS (5p / MB data and 4p / SMS thereafter)',
                'price' => 6600,
                'subscriptionType' => SubscriptionType::ANNUAL,
            ],
            [
                'title' => 'Standard: 12GB Data - 1 Year',
                'description' => 'Up to 12GB of data per year including 420 SMS (5p / MB data and 4p / SMS thereafter)',
                'price' => 10800,
                'subscriptionType' => SubscriptionType::ANNUAL,
            ],
            [
                'title' => 'Optimum: 24GB Data - 1 Year',
                'description' => 'Up to 24GB of data per year including 480 SMS (5p / MB data and 4p / SMS thereafter)',
                'price' => 17400,
                'subscriptionType' => SubscriptionType::ANNUAL,
            ],
        ];

        $this->assertSame($expected, $result);
    }
}
