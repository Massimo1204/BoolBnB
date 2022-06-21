<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Apartment;
use Illuminate\Support\Facades\Http;


class ApartmentController extends Controller
{
    public function index(){
        $apartments = Apartment::with(['messages','user'])->paginate(12);

        return response()->json($apartments);
    }
    public function allApartments(){
        $apartments = Apartment::all();

        return response()->json($apartments);
    }
    public function show($id){
        $apartment=Apartment::findOrFail($id);
        return response()->json($apartment);
    }
    public function search(Request $request){
        $address = $request->get("address");
        $apartmentFiltered = [];
            $response = Http::get('https://api.tomtom.com/search/2/search/' . $address . '.json?countrySet=IT&lat=37.337&lon=-121.89&extendedPostalCodesFor=Str&minFuzzyLevel=1&maxFuzzyLevel=2&view=Unified&relatedPois=off&key=' . env("APP_KEYMAPS") . '&countrySet=Italia');
            $dataResponse = json_decode($response->body(), true);
            // dd($dataResponse["results"][0]);
            $lat=$dataResponse["results"][0]["position"]["lat"];
            $lon=$dataResponse["results"][0]["position"]["lon"];
            $allApartments=Apartment::all();
            
            foreach ($allApartments as $apartment) {
                    $distance = self::haversineGreatCircleDistance($lat, $lon, $apartment->lat, $apartment->long);
                    if ($distance <= 20) {
                        array_push($apartmentFiltered,$apartment);
                    }
                }
                return compact("apartmentFiltered");
        
    }
    function haversineGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthMeanRadius = 6371)
    {
        $deltaLatitude = deg2rad($latitudeTo - $latitudeFrom);
        $deltaLongitude = deg2rad($longitudeTo - $longitudeFrom);
        $a = sin($deltaLatitude / 2) * sin($deltaLatitude / 2) +
            cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) *
            sin($deltaLongitude / 2) * sin($deltaLongitude / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthMeanRadius * $c;
    }
}