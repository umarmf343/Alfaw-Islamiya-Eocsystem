<?php

namespace Tests\Unit;

use App\Services\HasanatService;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function test_hasanat_calculation_counts_arabic_letters(): void
    {
        $service = new HasanatService();

        $this->assertSame(70, $service->calculateForText('بسم الله'));
    }
}
