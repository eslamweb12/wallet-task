<?php

namespace App\Http\Controllers;

use App\Factories\NotificationFactory;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function send( Request $request ){
        $request->validate([
            'type'=>'required|in:sms,push,email'
        ]);

        $notificationsender=NotificationFactory::create($request->get('type'));
        return $notificationsender->send();
    }
}
