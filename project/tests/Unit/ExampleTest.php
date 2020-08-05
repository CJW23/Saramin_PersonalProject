<?php

namespace Tests\Unit;


use App\Service\MainService;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        define('DOMAIN', "localhost:8000/");
        define("HTTP", "http://");
        define("MAX_TRY", 10);

    }

    public function testBasicTest()
    {
        DB::beginTransaction();
        $service = new MainService();
        $service->makeUrl(['url'=>"http://sammaru.cbnu.ac.kr"]);
        DB::rollback();
    }
}
