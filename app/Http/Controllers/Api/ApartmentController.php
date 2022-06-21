<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Apartment;
use App\Model\Service;
use Illuminate\Support\Facades\Http;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::with(['messages', 'user'])->paginate(12);

        return response()->json($apartments);
    }
    public function show($id){
        $apartment=Apartment::findOrFail($id);
        return response()->json($apartment);
    }
    public function filteredSearch(Request $request)
    {

        if ($request->get("address")) {
            $address = $request->get("address");
        } else {
            $response = [
                'result' => false,
                'data' => 'Nessun risultato'
            ];

            return compact('response');
        }


        if ($request->get("beds") || $request->get("beds") >= 0) {
            $beds = $request->get("beds");
        } else {
            $beds = 1;
        }

        if ($request->get("rooms") || $request->get("rooms") >= 0) {
            $rooms = $request->get("beds");
        } else {
            $rooms = 1;
        }

        if ($request->get("services")) {
            $services = $request->get("services");
        } else {
            $services = [];
        }

        if ($request->get("distance") || $request->get("distance") >= 20000) {
            $range = $request->get("distance");
        } else {
            $range = 20000;
        }


        // $resultAddress = api



        // $lat = $resultAddress['results'][0]['position']['lat'];
        // $lon = $resultAddress['results'][0]['position']['lon'];


        //query di ricerca
        $apartments = Apartment::with('services')
            ->where([['n_rooms', '>=', $rooms], ['n_beds', '>=', $beds]])
            ->where(function ($query) use ($services) {
                foreach ($services as $service) {
                    $query->whereHas('services', function ($query) use ($service) {
                        $query->where('id', $service);
                    });
                }
            })->get();



        // $filtered = [];
        // foreach ($apartments as $apartment) {
        //     $distance = self::functiondistance($lat, $lon, $apartment->latitude, $apartment->longitude);
        //     if ($distance <= $range) {
        //         $apartment->distance = $distance;
        //         array_push($filtered, $apartment);
        //     };
        // }

        // $response = [
        //     'result' => true,
        //     'data' => $filtered
        // ];
        // return compact('response');
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