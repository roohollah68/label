<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup as IKM;
use TelegramBot\Api\Types\ReplyKeyboardMarkup as RKM;

class TelegramController extends Controller
{

    public function receive(Request $request)
    {
//        $chat_id = $request->message->form->id;
        $chat_id = '90123252';
        $token = "1435869411:AAHZuaPosKamd2F0CtSt_v_DOM5xPN_WfP4";
        $bot = new BotApi($token);

        $user = User::where('telegram_id', $chat_id)->first();
        if ($user) {

        } else {
            $message = 'شما هنوز احراز هویت نشده اید. برای احراز هویت شماره تلگرام باید با شماره سامانه یکی باشد. در این صورت شماره خود را بفرستید.';
            $keyboard = new IKM([[[
                "text" => "ارسال شماره تماس",
                "request_contact" => true
            ]]]);
            $bot->sendMessage($chat_id, $message, null, false, null, $keyboard);
        }
        Storage::disk('public')->put('res.txt', json_encode($request->header()));

    }

}
