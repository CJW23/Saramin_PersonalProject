<?php

namespace App\Http\Controllers;
use App\Logic\UrlManager;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


class TestController extends Controller
{
    public function makeuser()
    {
        for($i = 0; $i<100; $i++)
        {
            $tmp = "tset".$i;
            $num = mt_rand(0, 1);
            User::create([
                'name'=>$tmp,
                'email'=>$tmp,
                'password'=>$tmp,
                'nickname'=>$tmp,
                'phone'=>$tmp,
                'admin'=>$num
            ]);
        }
        return view('error');
    }
}
