<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Picture;


class PicturesDeleteController extends Controller
{
    public function destroy($id)
    {
        // dd($id);
        $picture  = Picture::findOrFail($id);
        $apartmendId = $picture->apartment_id;
        $picture->delete();

        return redirect()->route('apartment.edit',$apartmendId )->with('deleted-message', 'La foto è stata eliminata con successo');
    }
}
