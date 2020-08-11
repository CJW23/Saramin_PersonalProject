<?php


namespace App\Logic;


class EncryptionModule
{
    private static $KEY = 'saramin';
    public static function encrypt($data)
    {
        return openssl_encrypt($data, 'aes-256-cbc', EncryptionModule::$KEY, 0,  str_repeat(chr(0), 16));
    }

    public static function decrypt($data)
    {
        //echo str_repeat(chr(0), 16);
        return openssl_decrypt($data, 'aes-256-cbc', EncryptionModule::$KEY, 0, str_repeat(chr(0), 16));
    }
}
