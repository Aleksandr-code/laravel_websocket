<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessageController extends Controller
{
    public function index(){
        $messages = Message::latest()->get();
        $messages = MessageResource::collection($messages)->resolve();
        return Inertia::render('Message/Index', [
            'messages' => $messages,
        ]);
    }

    public function store(StoreMessageRequest $request){
        //dd($request);
        $data = $request->validated();
        $message = Message::create($data);
        return MessageResource::make($message)->resolve();
        //return redirect()->back();
    }
}
