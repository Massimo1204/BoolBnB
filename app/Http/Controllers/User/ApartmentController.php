<?php

namespace App\Http\Controllers\User;

use App\Model\View;
use App\Model\Picture;
use App\Model\Service;
use App\Model\Apartment;
use App\Model\Sponsorship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::where('user_id',  Auth::user()->id)->orderBy('id', 'desc')->paginate(20);
        return view('user.apartments.index', compact("apartments"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::where('required', 1)->get();
        $sponsorships = Sponsorship::all();

        return view('user.apartments.create', compact('sponsorships','services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => ['required', 'string', 'min:5','max:255'],
            'image' => ['required'],
            'image.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => ['required', 'string','min:10','max:65000'],
            'n_rooms' => ['required', 'numeric','min:1'],
            'n_bedrooms' => ['required', 'numeric','min:1'],
            'n_bathrooms' => ['required', 'numeric','min:1'],
            'guests' => ['required', 'numeric','min:1'],
            'n_beds' => ['required', 'numeric','min:1'],
            'price' => ['required', 'numeric','min:1'],
            'address' => ['required', 'string','min:8'],
            'service' => ['required'],
        ],
        [
            "required" => "Non puoi inserire un Appartamento senza :attribute",
            "numeric" => " deve essere un numero",
            "min" => " è troppo corto",
        ]);

        $data = $request->all();
        $newAddress = rawurlencode($data['address']);
        $response = Http::get('https://api.tomtom.com/search/2/search/' . $newAddress . '.json?countrySet=IT&lat=37.337&lon=-121.89&extendedPostalCodesFor=Str&minFuzzyLevel=1&maxFuzzyLevel=2&view=Unified&relatedPois=off&key=' . env("APP_KEYMAPS") . '&countrySet=Italia');
        $dataResponse = json_decode($response->body(), true);
        if($dataResponse["results"] !== []){
            if(strtolower($dataResponse["results"][0]["address"]["freeformAddress"] . " " . $dataResponse["results"][0]["address"]["countryCode"]) == strtolower($data["address"]))
            {
                if($request['visible'] != null){
                    $data['visible'] = 1;
                }

                else{
                    $data['visible'] = 0;
                }

                if($request['available'] != null){
                    $data['available'] = 1;
                }
                else{
                    $data['available'] = 0;
                }

                $newApartment = new Apartment();
                $newApartment->title = $data["title"];
                $newApartment->user_id = Auth::user()->id;
                $newApartment->image = Storage::put('uploads',$data["image"]);
                $newApartment->description = $data["description"];
                $newApartment->n_rooms = $data["n_rooms"];
                $newApartment->n_bedrooms = $data["n_bedrooms"];
                $newApartment->n_beds = $data["n_beds"];
                $newApartment->n_bathrooms = $data["n_bathrooms"];
                $newApartment->guests = $data["guests"];
                $newApartment->visible = $data["visible"];
                $newApartment->available = $data["available"];
                $newApartment->price = $data["price"];
                $newApartment->square_meters = $data["square_meters"];
                $newApartment->lat = $dataResponse["results"][0]["position"]["lat"];
                $newApartment->long = $dataResponse["results"][0]["position"]["lon"];
                $newApartment->address = $data['address'];
                $newApartment->save();
                $images=array();
                if($files=$request->file('images')){
                    foreach($files as $file){
                        $newPicture = new Picture();
                        $newPicture->apartment_id = $newApartment->id;
                        $newPicture->image=Storage::put('uploads',$file);
                        $newPicture->save();
                    }
                }
                $newApartment->services()->sync($data['service']);

                return redirect()->route('apartment.index', ["apartment" => $newApartment]);
            }
            else{
                $request->validate([
                    'address' => ['numeric'],
                ],
                [
                    "numeric" => " Non riconosciamo questo indirizzo. L'hai inserito correttamente?",
                ]);
            }
        }
        else{
            $request->validate([
                'address' => ['numeric'],
            ],
            [
                "numeric" => " Non riconosciamo questo indirizzo. L'hai inserito correttamente?",
            ]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        $this->StoreView($apartment);
        return view('user.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        $services = Service::where('required', 1)->get();
        $sponsorships = Sponsorship::all();

        if($apartment->user_id == Auth::user()->id){
            return view('user.apartments.edit', compact('apartment', 'services', 'sponsorships') );
        }
        else{
            return redirect()->route('user.home')->with('error-message', 'Accesso negato');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        {
            $request->validate([
                'title' => ['required', 'string', 'min:10','max:255'],
                'image.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => ['required', 'string','min:10','max:65000'],
                'n_rooms' => ['required', 'numeric','min:1'],
                'n_bedrooms' => ['required', 'numeric','min:1'],
                'n_bathrooms' => ['required', 'numeric','min:1'],
                'guests' => ['required', 'numeric','min:1'],
                'n_beds' => ['required', 'numeric','min:1'],
                'price' => ['required', 'numeric','min:1'],
                'address' => ['required', 'string','min:3'],
                'service' => ['required'],
            ],
            [
                "required" => "Non puoi inserire un Appartamento senza :attribute",
            ]);
            $data = $request->all();
            $newAddress = rawurlencode($data['address']);
            $response = Http::get('https://api.tomtom.com/search/2/search/' . $newAddress . '.json?countrySet=IT&lat=37.337&lon=-121.89&extendedPostalCodesFor=Str&minFuzzyLevel=1&maxFuzzyLevel=2&view=Unified&relatedPois=off&key=' . env("APP_KEYMAPS") . '&countrySet=Italia');
            $dataResponse = json_decode($response->body(), true);
            if($dataResponse["results"] !== []){
                for ($i=0; $i < count($dataResponse["results"]); $i++) {

                    if(strtolower($dataResponse["results"][$i]["address"]["freeformAddress"] . " " . $dataResponse["results"][$i]["address"]["countryCode"]) == strtolower($data["address"]))
                    {
                        // dd($dataResponse["results"][$i]["position"]["lat"]);
                        // dd($dataResponse["results"][$i]);
                        if($request['visible'] != null)
                            $data['visible'] = 1;
                        else
                            $data['visible'] = 0;

                        if($request['available'] != null)
                            $data['available'] = 1;
                        else
                            $data['available'] = 0;

                        // $newAddress = str_replace(" ", "%20", $data['address']);
                        // $response = Http::get('https://api.tomtom.com/search/2/geocode/' . $newAddress . '.json?storeResult=false&view=Unified&key='.env("APP_KEYMAPS"));
                        // $dataResponse = json_decode($response->body(), true);

                        $apartment->title = $data["title"];
                        $apartment->user_id = Auth::user()->id;
                        if(isset($data["image"])){
                            $apartment->image = Storage::put('uploads',$data["image"]);
                        }
                        $apartment->description = $data["description"];
                        $apartment->n_rooms = $data["n_rooms"];
                        $apartment->n_bedrooms = $data["n_bedrooms"];
                        $apartment->n_beds = $data["n_beds"];
                        $apartment->n_bathrooms = $data["n_bathrooms"];
                        $apartment->guests = $data["guests"];
                        if(isset($data["visible"]))
                        $apartment->visible = $data["visible"];
                        if(isset($data["available"]))
                        $apartment->available = $data["available"];
                        if($files=$request->file('images')){
                            foreach($files as $file){
                                $newPicture = new Picture();
                                $newPicture->apartment_id = $apartment->id;
                                $newPicture->image=Storage::put('uploads',$file);
                                $newPicture->save();
                            }
                        }
                        $apartment->price = $data["price"];
                        $apartment->square_meters = $data["square_meters"];
                        $apartment->lat = $dataResponse["results"][$i]["position"]["lat"];
                        $apartment->long = $dataResponse["results"][$i]["position"]["lon"];
                        $apartment->address = $data["address"];
                        $apartment->save();
                        $apartment->services()->sync($data['service']);

                        return redirect()->route('apartment.index', compact('apartment'));
                    }
                }
                    // else{
                        // dd(strtolower($dataResponse["results"][0]["address"]["freeformAddress"]));
                        $request->validate([
                            'address' => ['numeric'],
                        ],
                        [
                            "numeric" => " Non riconosciamo questo indirizzo. L'hai inserito correttamente?",
                        ]);
                    }
            // }
            else{
                $request->validate([
                    'address' => [ 'numeric'],
                ],
                [
                    "numeric" => " Non riconosciamo questo indirizzo. L'hai inserito correttamente?",
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->route('apartment.index')->with('deleted-message', 'The selected apartment has been deleted');
    }


    public function StoreView($apartment){
        $clientIP = request()->ip();
        $Apartment_id=$apartment->id;
        $newViewer=new View();
        $newViewer->apartment_id=$Apartment_id;
        $newViewer->ip_address=$clientIP;
        $newViewer->save();
    }
}
