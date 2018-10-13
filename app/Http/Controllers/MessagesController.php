<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
class MessagesController extends Controller
{
    public function show(Message $message) {
        // ir a buscar el messages por ID
        
        // una view de un messages
        return view('messages.show', [
            'message' => $message
        ]);
    }
    public function create(Request $request) {
        dd($request->all());
        return "Created!!";
    }
}
