<?php

namespace App\Http\Controllers;

use App\Notifications\newCommande;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(){


        $notifications = DatabaseNotification::all()->sortByDesc('created_at')->sortBy('read_at');

        //dd($notifications);
        return view('inbox' , [
            'notifications' => $notifications
        ]);
    }


    public function destroy( $notification){
        $notification = DatabaseNotification::find($notification);

        $notification->delete();
        return redirect()->route('inbox.index');
    }

    public function show($notification){
        $notification = DatabaseNotification::find($notification);
        //dd($notification);
        $notification->markAsRead();
        return redirect()->route('inbox.index');
    }
}
