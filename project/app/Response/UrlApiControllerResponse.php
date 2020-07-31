<?php


namespace App\Response;


use Illuminate\Support\Facades\Log;

class UrlApiControllerResponse
{
    function createUrlResponse($url, $method, $msg, $text = null)
    {
        if ($text == null) {
            Log::channel('single')->debug( $method . ": " . $msg);
        } else {
            Log::channel('single')->debug($method . ": " . $text);
        }
        return [
            'shortUrl' => 'false',
            'originalUrl' => $url,
            'msg' => $msg
        ];
    }

    function createUserUrlResponse($method, $msg, $text = null)
    {
        Log::channel('single')->critical( $method . ": " . $msg);
        return [
            'rst' => 'false',
            'msg' => $msg
        ];
    }

    function errorResponse($method, $msg)
    {
        Log::channel('single')->critical($method . ": " . $msg);
        return response("", 500);
    }
}
