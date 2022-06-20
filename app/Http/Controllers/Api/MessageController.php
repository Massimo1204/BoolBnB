<?php

namespace App\Http\Controllers\Api;

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
                'full_name.required' => 'Il nome è obbligatorio [da Laravel].',
                'email.required' => 'La mail è obbligatoria [da Laravel].',
                'email.email' => 'L\'indirizzo email non è valido [da Laravel].',
                'text.required' => 'Il testo del messaggio è obbligatorio [da Laravel].'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // else{
        //     $message = new Message();
        //     $message->fill($data);
        //     $message->save();
        //     return response()->json(['ok' => "ok"]);
        // };

        $message = new Message();
            $message->fill($data);
            $message->save();


        //$data['email'] = "";
        $mail = new SendNewMail($data);
        try {
            Mail::to(env('MAIL_ADMIN_ADDRESS'))->send($mail); // MAIL_ADMIN_ADDRESS è stata aggiunta nel file ENV
            return response('Email inviata con successo', 204); // o return response('Mail received', 201)
        } catch (ModelNotFoundException  $exception) {
            return response('Messaggio non inviato. Si è verificato un errore. Riprovare più tardi [da Laravel]', 204); // o return response('Mail received', 201)
        }
    }

    public function getApartmentMessages(Apartment $apartment){
        $messages = $apartment->messages;

        return response()->json($messages);
    }
}
