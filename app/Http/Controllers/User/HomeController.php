<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Model\Apartment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $apartments = Apartment::paginate(12);
        return view('user.home', compact('apartments'));
    }
}
