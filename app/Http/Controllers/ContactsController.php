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
        $contacts = User::with(['profile'])->where('id','!=',auth()->id())->get();
        foreach($contacts as $contact)
        {
            $contact->profile->image = $contact->profile->profileImage();
        }

        $unreadIds = Message::select(\DB::raw('`from_user` as sender_id, count(`from_user`) as messages_count'))
            ->where('to_user', auth()->id())
            ->where('read', false)
            ->groupBy('from_user')
            ->get();
        
        $contacts = $contacts->map(function($contact) use($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();

            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

            return $contact;
        });

        return response()->json($contacts);
    }

    public function getMessagesFor($id)
    {
        Message::where('from_user', $id)->orWhere('to_user', $id)->get();

        $messages = Message::where(function($q) use ($id) {
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
