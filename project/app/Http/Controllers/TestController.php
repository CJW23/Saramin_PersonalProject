<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    //url id최대값 출력 테스트
    public function maxIdTest()
    {
        $val = DB::table("urls")->select("id")->max("id");
        return View('test', [
            'val' => $val,
        ]);
    }
}
