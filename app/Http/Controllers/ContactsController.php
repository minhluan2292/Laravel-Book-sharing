<?php

namespace App\Http\Controllers;

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
         return response()->json($messages);
     }
}
