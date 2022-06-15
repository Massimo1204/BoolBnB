<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Model\Apartment;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::paginate(5);
        return view('guest.home', compact("apartments"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.apartments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'unique:posts|required|max:20',
        //     'description' => 'required|min:10',
        // ]);

        $data = $request->all();

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

        // dd($data);

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
        $newApartment->lat = $data["lat"];
        $newApartment->long = $data["long"];
        $newApartment->address = $data["address"];
        $newApartment->save();
        // $newApartment->()->sync($data['category_id']);

        return redirect()->route('home.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        return view('user.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

        return redirect()->route('guest.home')->with('deleted-message', 'The selected apartment has been deleted');
    }
}
