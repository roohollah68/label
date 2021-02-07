<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request as Request2;
use Illuminate\Support\Facades\Storage;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Request;

class TelegramController extends Controller
{
    public $telegram;

    public function __construct()
    {
        $token = "1435869411:AAHZuaPosKamd2F0CtSt_v_DOM5xPN_WfP4";
        $telegram = new Telegram($token);
    }

    public function receive(Request2 $request)
    {
        $chat_id = $request->message->form->id;
        $user = User::where('telegram_id', $chat_id);
        if ($user) {

        } else {
            Request::sendMessage([
                'chat_id' => $chat_id,
                'text'    => 'you are not authorized',
            ]);

        }
        Storage::disk('public')->put('res.txt', json_encode($request->header()));

    }

}
