<?php

namespace App\Strategy;

class DebitTaxStrategy implements PaymentTaxStrategy
{
    public function calculate(float $value): float
    {
        return $value * 1.03;
    }
}