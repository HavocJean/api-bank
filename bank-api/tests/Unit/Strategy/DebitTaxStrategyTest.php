<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Strategy\DebitTaxStrategy;

class DebitTaxStrategyTest extends TestCase
{
    public function testShouldCalculateDebitTax()
    {
        $strategy = new DebitTaxStrategy();

        $result = $strategy->calculate(10);

        $this->assertEquals(10.3, $result);
    }
}