<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Model\Message;
use App\Model\Apartment;
use App\Mail\SendNewMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MessageController extends Controller
{
    public function index(){
        $messages = Message::all();

        return response()->json($messages);
    }

    public function store(Request $request){


        $data = $request->all();
        // # Validazione
        $validator = Validator::make(
            $data,
            [
                'full_name' => 'required',
                'email' => 'required|email',
                'text' => 'required'
            ],
            [
                'full_name.required' => 'Il nome è obbligatorio .',
                'email.required' => 'La mail è obbligatoria .',
                'email.email' => 'L\'indirizzo email non è valido .',
                'text.required' => 'Il testo del messaggio è obbligatorio .'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }


        $message = new Message();
            $message->fill($data);
            $message->save();


        $user_id = Apartment::select('user_id')->where('id', $data['apartment_id'])->first();
        $id = $user_id->user_id;
        $user_email = User::select('email')->where('id', $id)->first();
        $email = $user_email->email;
        $mail = new SendNewMail($data);
        try {
            Mail::to($email)->send($mail);
            return response('Email inviata con successo', 204);
        } catch (ModelNotFoundException  $exception) {
            return response('Messaggio non inviato. Si è verificato un errore. Riprovare più tardi', 204);
        }
    }

    public function getApartmentMessages(Apartment $apartment){
        $messages = $apartment->messages;

        return response()->json($messages);
    }
}
