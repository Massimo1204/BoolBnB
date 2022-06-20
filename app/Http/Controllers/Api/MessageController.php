<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Apartment;
use App\Model\Message;

class MessageController extends Controller
{
    public function index(){
        $messages = Message::all();

        return response()->json($messages);
    }

    public function store(Request $request){

    }

    public function getApartmentMessages(Apartment $apartment){
        $messages = $apartment->messages;

        return response()->json($messages);
    }
}
