<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Sponsorship;
use App\Model\Apartment;

class SponsorshipController extends Controller
{
    public function index(Apartment $apartment){
        $sponsorships = Sponsorship::all();
        return view('features.sponsorships.index', compact('sponsorships', 'apartment'));
    }
}
