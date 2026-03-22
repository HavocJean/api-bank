<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Strategy\CreditTaxStrategy;

class CreditTaxStrategyTest extends TestCase
{
    public function testShouldCalculateCreditTax()
    {
        $strategy = new CreditTaxStrategy();
    
        $result = $strategy->calculate(10);
    
        $this->assertEquals(10.5, $result);
    }
}