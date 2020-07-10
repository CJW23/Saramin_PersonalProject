<?php

namespace Tests\Unit;

use App\Logic\UrlManager;
use Base62\Base62;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $base62 = new UrlManager();
        $a = $base62->encodingUrl("123123");
        $this->assertSame($a, 123);
    }
}
