<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Http\Requests\CreateMessageRequest;
class MessagesController extends Controller
{
    public function show(Message $message) {
        // ir a buscar el messages por ID
        
        // una view de un messages
        return view('messages.show', [
            'message' => $message
        ]);
    }
    public function create(CreateMessageRequest $request) {
        $user = $request->user();
        $message = Message::create([
            'user_id' => $user->id,
            'content' => $request->input('message'),
            'image' => 'http://source.unsplash.com/category/nature/600x338?'.mt_rand(1, 100)
        ]);

        return redirect('/messages/'.$message->id);
    }
}
