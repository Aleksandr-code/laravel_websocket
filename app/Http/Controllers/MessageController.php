<?php

namespace App\Http\Controllers;

use App\Events\MessagePrivateSubmitted;
use App\Events\MessagePublicSubmitted;
use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use App\Models\User;
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
        $data = $request->validated();
        $message = Message::create($data);
        broadcast(new MessagePublicSubmitted($message))->toOthers();
        // приватное сообщение определенному пользователю
        //$userTwo = User::find(2);
        //broadcast(new MessagePrivateSubmitted($userTwo, $message));
        //broadcast(MessagePrivateSubmitted::dispatch(MessageResource::make(auth()->user(), $message)->resolve()))->toOthers();
        return MessageResource::make($message)->resolve();
    }
}
