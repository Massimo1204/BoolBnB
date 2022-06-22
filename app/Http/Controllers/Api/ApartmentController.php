<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Sponsorship;
use App\Model\Apartment;
use App\Model\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::with(['messages', 'user'])->paginate(12);

        return response()->json($apartments);
    }
    public function show($id)
    {
        $apartment = Apartment::findOrFail($id);
        return response()->json($apartment);
    }

    public function search(Request $request)
    {
        $address = $request->get("address");
        $apartmentFiltered = [];
        $response = Http::get('https://api.tomtom.com/search/2/search/' . $address . '.json?countrySet=IT&lat=37.337&lon=-121.89&extendedPostalCodesFor=Str&minFuzzyLevel=1&maxFuzzyLevel=2&view=Unified&relatedPois=off&key=' . env("APP_KEYMAPS") . '&countrySet=Italia');
        $dataResponse = json_decode($response->body(), true);
        // dd($dataResponse["results"][0]);
        $lat = $dataResponse["results"][0]["position"]["lat"];
        $lon = $dataResponse["results"][0]["position"]["lon"];
        $allApartments = Apartment::all();

        foreach ($allApartments as $apartment) {
            $distance = self::haversineGreatCircleDistance($lat, $lon, $apartment->lat, $apartment->long);
            if ($distance <= 20) {
                array_push($apartmentFiltered, $apartment);
            }
        }
        return compact("apartmentFiltered");
    }

    public function filteredSearch(Request $request)
    {

        if ($request->get("address") != null) {
            $address = $request->get("address");
        } else {
            $response = [
                'result' => false,
                'data' => 'Nessun risultato'
            ];

            return compact('response');
        }


        if ($request->get("beds")) {
            $beds = $request->get("beds");
        } else {
            $beds = 1;
        }

        if ($request->get("rooms")) {
            $rooms = $request->get("rooms");
        } else {
            $rooms = 1;
        }

        if ($request->get("services")) {
            $services = json_decode($request->get("services"));
        }
        else {
            $services = [];
        }

        if ($request->get("distance")) {
            $range = $request->get("distance");
        } else {
            $range = 20;
        }


        $response = Http::get('https://api.tomtom.com/search/2/search/' . $address . '.json?countrySet=IT&lat=37.337&lon=-121.89&extendedPostalCodesFor=Str&minFuzzyLevel=1&maxFuzzyLevel=2&view=Unified&relatedPois=off&key=' . env("APP_KEYMAPS") . '&countrySet=Italia');
        $dataResponse = json_decode($response->body(), true);

        $lat = $dataResponse["results"][0]["position"]["lat"];
        $lon = $dataResponse["results"][0]["position"]["lon"];


        $apartments = Apartment::with('services')
            ->where('n_rooms', '>=', $rooms)
            ->where('n_beds', '>=', $beds)
            ->where(function ($query) use ($services) {
                foreach ($services as $service) {
                    $query->whereHas('services', function ($query) use ($service) {
                        $query->where('id', $service);
                    });
                }
            })
            ->get();

        $filtered = [];
        foreach ($apartments as $apartment) {
            $distance = self::haversineGreatCircleDistance($lat, $lon, $apartment->lat, $apartment->long);
            if ($distance <= $range) {
                array_push($filtered, $apartment);
            };
        }

        $response = [
            'result' => true,
            'data' => $filtered
        ];
        return compact('response');
    }

    public function haversineGreatCircleDistance(
        $latitudeFrom,
        $longitudeFrom,
        $latitudeTo,
        $longitudeTo,
        $earthMeanRadius = 6371
    ) {
        $deltaLatitude = deg2rad($latitudeTo - $latitudeFrom);
        $deltaLongitude = deg2rad($longitudeTo - $longitudeFrom);
        $a = sin($deltaLatitude / 2) * sin($deltaLatitude / 2) +
            cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) *
            sin($deltaLongitude / 2) * sin($deltaLongitude / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthMeanRadius * $c;
    }

    public function getSponsored(){
        $today = Carbon::now('Europe/Rome');
        
        $sponsorships = Sponsorship::with('apartments')->get();

        foreach($sponsorships as $sponsorship){
            $available[] = $sponsorship->apartments()->wherePivot('end_date', '>', $today)->get();
        }

        return response()->json($available);
    }
}
