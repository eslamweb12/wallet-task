<?php

namespace App\Services\Notifications;

use App\Interfaces\Notification;

class Sms implements Notification
{
    public function send(){
        return "send notification by sms";
    }

}
