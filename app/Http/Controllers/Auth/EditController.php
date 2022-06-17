<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return view('auth.edit', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255','min:2'],
            'last_name' => ['required', 'string', 'max:255','min:2'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'profile_picture' => ['mimes:jpeg,jpg,png,gif'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required_with:password','same:password']
        ],
        [
            "required" => "Non puoi aggiornare uno User senza :attribute.",
        ]
        );
        $request['password'] = Hash::make($request['password']);
        $data = $request->all();
        if($request['profile_picture'] != null){

            $data['profile_picture'] = Storage::put('uploads', $data['profile_picture']);
        }


        $user->update($data);
        return redirect()->route('login');
    }

}
