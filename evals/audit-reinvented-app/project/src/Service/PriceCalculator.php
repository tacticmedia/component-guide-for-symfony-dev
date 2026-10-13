<?php

namespace App\Service;

final class PriceCalculator
{
    private const float VAT_RATE = 0.2;

    /**
     * Loyalty tiers agreed with the sales team: 5% from 10 orders, 10% from 50 orders.
     */
    public function finalPrice(float $netPrice, int $previousOrders): float
    {
        $discount = match (true) {
            $previousOrders >= 50 => 0.10,
            $previousOrders >= 10 => 0.05,
            default => 0.0,
        };

        return round($netPrice * (1 - $discount) * (1 + self::VAT_RATE), 2);
    }
}
