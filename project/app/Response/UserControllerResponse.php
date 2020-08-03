<?php


namespace App\Response;


use Illuminate\Support\Facades\Log;

class UserControllerResponse
{
    function editInfoResponse(string $rst, string $method, string $msg = null)
    {
        if ($msg != null) {
            Log::channel('single')->debug($method . ": " . $msg);
        }
        return [
            'rst' => $rst
        ];
    }

    function editPasswordResponse(int $type, string $rst, string $method, string $msg = null)
    {
        if($msg != null){
            Log::channel('single')->debug($method . ": " . $msg);
        }
        return[
            'type' => $type,
            'rst' => $rst
        ];
    }

    function editNicknameResponse(string $rst, string $method, string $msg = null)
    {
        if ($msg != null) {
            Log::channel('single')->debug($method . ": " . $msg);
        }
        return [
            'rst' => $rst
        ];
    }

    function checkNicknameResponse(string $rst)
    {
        return [
            'rst' => $rst
        ];
    }

    function dropUserResponse(string $rst, string $method, string $msg = null)
    {
        if($msg != null){
            Log::channel('single')->debug($method . ": " . $msg);
        }
        return [
            'rst' =>$rst
        ];
    }
}
