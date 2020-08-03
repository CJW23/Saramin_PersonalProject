<?php


namespace App\Response;


use Illuminate\Support\Facades\Log;

class AdminApiControllerResponse
{
    function response(string $rst, string $method, string $msg = null)
    {
        if($msg != null){
            Log::channel('single')
                ->debug($method . ": " . $msg);
            return [
                'result' => $rst
            ];
        }
        return [
            'result' => $rst
        ];
    }
}
