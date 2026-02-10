<?php

namespace App\Services\Notifications;

use App\Interfaces\Notification;

class Push implements Notification
{
    public function send(){
        return "send notification by push";
    }

}
