<?php

namespace App\Keyboards;

class Keyboard
{
    public static $request_phone = array(array([
        "text" => "ارسال شماره تماس",
        "request_contact" => true
    ]));

    public static function register_user($url)
    {
        return array(array([
            "text" => "ثبت نام",
            "url" => $url
        ]));
    }


}
