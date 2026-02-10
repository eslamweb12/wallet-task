<?php

namespace App\Factories;

use App\Services\Notifications\Email;
use App\Services\Notifications\Push;
use App\Services\Notifications\Sms;

class NotificationFactory
{
    public static function create($type){
        return match($type){
            'sms'=>new Sms(),
            'push'=>new Push(),
            'email'=>new Email(),

        };
    }
}
