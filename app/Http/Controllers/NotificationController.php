<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Notifications\newCommande;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(){
        $nouveau =  User::whereHas('roles', function($q){$q->whereIn('name', ['nouveau']);})->where('deleted_at',NULL)->count();


        if(!Gate::denies('ramassage-commande')){
           
            $notifications = DatabaseNotification::all()->sortByDesc('created_at')->sortBy('read_at')->where('notifiable_id',1);
        }
        else{
            $user =Auth::user()->id;
            $notifications = DatabaseNotification::all()->sortByDesc('created_at')->sortBy('read_at')->where('notifiable_id',$user);
            //dd($notifications);
        }

        return view('inbox' , [
            'nouveau'=>$nouveau,
            'notifications' => $notifications
        ]);
    }


    public function destroy( $notification){
        $notification = DatabaseNotification::find($notification);

        $notification->delete();
        return redirect()->route('inbox.index');
    }

    public function show($notification){
        if(!Gate::denies('ramassage-commande')){
        $notification = DatabaseNotification::find($notification);
        }
        else{
        $notification = DatabaseNotification::find($notification);
        }
        //dd($notification);
        $notification->markAsRead();
        return redirect()->route('inbox.index');
    }
}
