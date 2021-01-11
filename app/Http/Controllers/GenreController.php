<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use Session;
use Illuminate\Support\Facades\Auth;

class GenreController extends Controller
{
    public function getGenres(){
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        $user = Auth::user();
        $genres = Genre::all();
        return view('formGenre', compact('genres', 'erreur', 'user'));
    }
}
