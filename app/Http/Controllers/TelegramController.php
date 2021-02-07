<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use TelegramBot\Api\BotApi;

class TelegramController extends Controller
{
    public $bot;

    public function __construct()
    {
        $token = "1435869411:AAHZuaPosKamd2F0CtSt_v_DOM5xPN_WfP4";
        $bot = new BotApi($token);
    }

    public function receive(Request $request)
    {
        $chat_id = $request->message->form->id;
        $user = User::where('telegram_id', $chat_id);
        if ($user) {

        } else {
            $this->bot->sendMessage([
                'chat_id' => $chat_id,
                'text'    => 'you are not authorized',
            ]);

        }
        Storage::disk('public')->put('res.txt', json_encode($request->header()));

    }

}
