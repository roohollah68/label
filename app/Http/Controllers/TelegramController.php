<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function receive(Request $request)
    {
        return $request['update_id'];
    }
}
