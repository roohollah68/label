<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TelegramController extends Controller
{
    public function receive(Request $request)
    {
        Storage::disk('public')->put('res.txt', $request);
//        file_put_contents('res.txt',$request->url());
    }
}
