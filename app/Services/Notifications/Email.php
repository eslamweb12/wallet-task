<?php

namespace App\Services\Notifications;

use App\Interfaces\Notification;

class Email implements Notification
{
    public function send(){
        return "send notification by mail";
    }

}
