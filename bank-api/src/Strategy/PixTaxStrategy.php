<?php

namespace App\Strategy;

class PixTaxStrategy implements PaymentTaxStrategy
{
    public function calculate(float $value): float
    {
        return $value;
    }
}