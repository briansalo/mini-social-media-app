<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Message;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

use App\Events\MessageSent;

class ChatController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function selectedusers(Request $request, $receiver_id){
        $receiveruser= User::find($receiver_id);
        return view('backend.chat.chat-user')->with(compact('receiver_id','receiveruser'));
    }


    public function fetchMessages($receiver_id)
    {
       return Message::with('user')->where('user_id', $receiver_id)->where('receiver_id', Auth::user()->id)
       ->orwhere('user_id', Auth::user()->id)
       ->where('receiver_id', $receiver_id)
       ->latest()//since our css in chatmessage is in reverse, we need to get the latest in order to organize our message
       ->get();

    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $message = $user->messages()->create([
            'receiver_id'=> $request->receiver_id,
            'message' => $request->message,
            
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();
        return $message->load('user');
    }


}
