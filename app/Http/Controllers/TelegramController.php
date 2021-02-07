<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use TelegramBot\Api\BotApi;

class TelegramController extends Controller
{

    public function receive(Request $request)
    {
        $chat_id = $request->message->form->id;
        $token = "1435869411:AAHZuaPosKamd2F0CtSt_v_DOM5xPN_WfP4";
        $bot = new BotApi($token);

        $user = User::where('telegram_id', $chat_id)->first();
        if ($user) {

        } else {
            $bot->sendMessage($chat_id, 'you are not authorized');
        }
        Storage::disk('public')->put('res.txt', json_encode($request->header()));

    }

}
