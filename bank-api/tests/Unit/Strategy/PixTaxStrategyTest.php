<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Strategy\PixTaxStrategy;

class PixTaxStrategyTest extends TestCase
{
    public function testShouldCalculatedebixTax()
    {
        $strategy = new PixTaxStrategy();

        $result = $strategy->calculate(10);

        $this->assertEquals(10, $result);
    }
}