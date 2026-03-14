<?php

namespace App\Strategy;

class CreditTaxStrategy implements PaymentTaxStrategy
{
    public function calculate(float $value) :float
    {
        return $value * 1.05;
    }
}