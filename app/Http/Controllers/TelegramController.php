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
        $req = json_decode(file_get_contents('php://input'));
        $chat_id = $req->message->from->id;
//        $chat_id = '90123252';
        $token = "1435869411:AAHZuaPosKamd2F0CtSt_v_DOM5xPN_WfP4";
        $bot = new BotApi($token);

        $user = User::where('telegram_id', $chat_id)->first();
        if ($user) {

        } else {
            if(isset($req->message->contact->phone_number)){
                $phone = $req->message->contact->phone_number;
                $phone = '0'.substr($phone , -10);
                $user = User::where('phone', $phone)->first();
                if($user){
                    $user->update(['telegram_id'=>$chat_id]);
                    $message = "
تبریک حساب شما با موفقیت متصل شد
اطلاعات ثبت شده از شما:
نام و نام خانوادگی: {$user->name}
نام کاربری: {$user->username}
";
                    $bot->sendMessage($chat_id,$message);
                }else{
                    $message = "متاسفانه با این شماره تلفن حسابی وجود ندارد";
                    $bot->sendMessage($chat_id,$message);
                }
            }else {
                $message = 'شما هنوز احراز هویت نشده اید. برای احراز هویت شماره تلگرام باید با شماره سامانه یکی باشد. در این صورت با زدن دکمه "ارسال شماره تماس" شماره خود را بفرستید.';
                $keyboard = new RKM([[[
                    "text" => "ارسال شماره تماس",
                    "request_contact" => true
                ]]]);
                $bot->sendMessage($chat_id, $message, null, false, null, $keyboard);
            }
        }
        Storage::disk('public')->put('res.txt', json_encode($request->all()));

    }

}
