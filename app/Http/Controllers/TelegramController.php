<?php

namespace App\Http\Controllers;

use App\Keyboards\Keyboard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup as IKM;
use TelegramBot\Api\Types\ReplyKeyboardMarkup as RKM;

class TelegramController extends Controller
{
    public $bot;
    public $chat_id;
    public $req;

    public function receive(Request $request)
    {
        $this->req = json_decode(file_get_contents('php://input'));
        $this->chat_id = $this->req->message->from->id;
        $token = '1435869411:AAHZuaPosKamd2F0CtSt_v_DOM5xPN_WfP4';
        $this->bot = new BotApi($token);

        $user = User::where('telegram_id', $this->chat_id)->first();
        if ($user) {
            $keyboard = new RKM(Keyboard::$user_option);
            $message = 'برای ثبت فاکتور تصویر رسید بانکی را به همین ربات بفرستید.';
            $type = $this->detect_type();
            if ($type == 'text'){
                $text = $this->req->message->text;
                if($text == Keyboard::$user_option[0][0])
                    $this->see_orders(1,$user);
                if($text == Keyboard::$user_option[0][1])
                    $this->see_orders(5,$user);
                if($text == Keyboard::$user_option[1][0])
                    $this->list_orders($user);
                if($text == Keyboard::$user_option[1][1])
                    $this->new_order($user);
            }
            if($type == 'photo'){

            }


            $this->bot->sendMessage($this->chat_id, $message, null, false, null, $keyboard);
        } else {
            if (isset($this->req->message->contact->phone_number)) {
                $phone = $this->req->message->contact->phone_number;
                $phone = '0' . substr($phone, -10);
                $user = User::where('phone', $phone)->first();
                if ($user)
                    $this->confirm_phone($user);
                else
                    $this->register_user();
            } else
                $this->request_phone();
        }
        Storage::disk('public')->put('res.txt', json_encode($request->all()));

    }

    public function request_phone()
    {
        $message = 'شما هنوز احراز هویت نشده اید. برای احراز هویت شماره تلگرام باید با شماره سامانه یکی باشد. در این صورت با زدن دکمه "ارسال شماره تماس" شماره خود را بفرستید.';
        $keyboard = new RKM(Keyboard::$request_phone);
        $this->bot->sendMessage($this->chat_id, $message, null, false, null, $keyboard);
    }

    public function confirm_phone($user)
    {
        $user->update(['telegram_id' => $this->chat_id]);
        $message = "
تبریک حساب شما با موفقیت متصل شد
اطلاعات ثبت شده از شما:
نام و نام خانوادگی: {$user->name}
نام کاربری: {$user->username}
";
        $this->bot->sendMessage($this->chat_id, $message);

    }

    public function register_user()
    {
        $phone = $this->req->message->contact->phone_number;
        $phone = '0' . substr($phone, -10);
        $name = $this->req->message->contact->first_name . ' ' . $this->req->message->contact->last_name;
        $url = "https://label.binancerobot.com/register?name={$name}&phone={$phone}&telegram_id={$this->chat_id}";
        $keyboard = new IKM(Keyboard::register_user($url,"ثبت نام"));
        $message = "
متاسفانه با این شماره تلفن حسابی وجود ندارد
برای ایجاد حسساب به لینک زیر بروید:";
        $this->bot->sendMessage($this->chat_id, $message, null, false, null, $keyboard);
    }

    public function detect_type()
    {
        if (isset($this->req->message->text))
            return 'text';
        if (isset($this->req->message->photo))
            return 'photo';
    }

    public function see_orders($count , $user)
    {
        $orders = $user->orders()->orderBy('id', 'desc')->limit($count)->get();
        foreach ($orders as $order){
            $message = "
نام و نام خانوادگی: {$order->name}
شماره همراه: {$order->phone}
آدرس: {$order->address}
سفارشات: {$order->orders}
کدپستی: {$order->zip_code}
توضیحات: {$order->desc}
            ";
            $this->bot->sendMessage($this->chat_id, $message);
        }
    }

    public function list_orders($user)
    {
        $message = "برای دیدن لیست کامل فاکتورها به آدرس زیر بروید:";
        $url = env('APP_URL')."list-orders/".$user->id.'/'.$user->password;
        $keyboard = new IKM(Keyboard::register_user($url,"مشاهده تمام فاکتورها"));
        $this->bot->sendMessage($this->chat_id, $message, null, false, null, $keyboard);
    }

    public function new_order($user)
    {
        $message = "برای ثبت فاکتور جدید به آدرس زیر بروید:";
        $url = env('APP_URL')."new-order/".$user->id.'/'.$user->password;
        $keyboard = new IKM(Keyboard::register_user($url,"ثبت فاکتور جدید"));
        $this->bot->sendMessage($this->chat_id, $message, null, false, null, $keyboard);
    }
}
