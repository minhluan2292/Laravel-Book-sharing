<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Message;
use App\User;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function get()
    {
        $contacts = User::with(['profile'])->get();
        foreach($contacts as $contact)
        {
            $contact->profile->image = $contact->profile->profileImage();
        }
        return response()->json($contacts);
    }

    public function getMessagesFor($id)
    {
        $messages = Message::where('from_user', $id)->orWhere('to_user', $id)->get();

        $message = Message::where(function($q) use ($id) {
            $q->where('from_user', auth()->id());
            $q->where('to_user', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('from_user', $id);
            $q->where('to_user', auth()->id());
        })
        ->get();

        return response()->json($messages);

    }

    public function send(Request $request)
    {             
        $message = Message::create([
            'from_user' => auth()->id(),
            'to_user' => $request->contact_id,
            'text' => $request->text
        ]);

        broadcast(new NewMessage($message));

        return response()->json($message);
    }

}
