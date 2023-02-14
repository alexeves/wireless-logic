<?php

declare(strict_types=1);

namespace WirelessLogic\Domain\Products;

enum SubscriptionType: string
{
    case ANNUAL = 'Annual';
    case MONTHLY = 'Monthly';
}
