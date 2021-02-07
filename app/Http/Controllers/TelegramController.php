<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function receive(Request $request)
    {
        file_put_contents('res.txt',$request->url());
    }
}
