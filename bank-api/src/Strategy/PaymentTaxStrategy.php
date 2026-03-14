<?php

namespace App\Strategy;

interface PaymentTaxStrategy
{
    public function calculate(float $value) :float;
}