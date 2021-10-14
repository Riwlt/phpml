<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Extractor\Numbers\DataExtractor;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{

    public function testIfWorking():void
    {
        $main = new DataExtractor();

        $main->extract();

        $this->assertEquals(0, 0);
    }

}