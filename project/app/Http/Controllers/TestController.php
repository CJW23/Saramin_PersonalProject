<?php

namespace App\Http\Controllers;
use App\Logic\UrlManager;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


class TestController extends Controller
{
    public function test(){
        $urlManager = new UrlManager();

        if($urlManager->urlExists())
        {
            return "true";
        }
        else
        {
            return 'false';
        }
    }

    public function test1(){
        return view('test');
    }
}
