<?php

namespace Tests\Unit;

use App\Service\MainService;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MainServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     * @throws \App\Exceptions\UrlException
     */
    public function testExample()
    {
        DB::beginTransaction();
        $service = new MainService();
        $rst = $service->makeUrl(['url'=>"http://sammaru.cbnu.ac.kr"]);
        self::assertSame("http://sammaru.cbnu.ac.kr", $rst);
    }
}
