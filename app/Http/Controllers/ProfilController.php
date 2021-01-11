<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Lecteur;


class ProfilController extends Controller
{
    public function getProfil(){
        $erreur = "";
        $user = Auth::user();
        $id_lecteur = $user->id;
        $lecteur = Lecteur::find($id_lecteur);
        return view('formProfil', compact('lecteur', 'user', 'erreur'));
    }
    
    /*
     * enregistre le profil
     * @return vue Home
     */
    
    public function setProfil(){
        // messages d'erreurs personnalisés
        $messages = array(
            'nom.required' => 'Il faut saisir un nom.',
            'prenom.required' => 'Il faut saisir un prénom.', 
            'cp.required' => 'Il faut saisir un code postal.', 
            'cp.numeric' => 'Le code postal doit être une valeur numérique.'            
        );
        //liste des champs à vérifier
        $regles = array(
            'nom' => 'required', 
            'prenom' => 'required', 
            'cp' => 'required | numeric'
        );
        
        $validator = Validator::make(Request::all(), $regles, $messages);
        
        // on retourne au formulaire s'il y a un problème
        if($validator->fails()){
            return redirect('profil')
                ->withErrors($validator)
                ->withInput();
        }
        
        // on récupère les données et on les enregistre
        $user = Auth::user();
        $id_lecteur = $user->id;
        $lecteur = Lecteur::find($id_lecteur);
        $lecteur->nom = Request::input('nom');
        $lecteur->prenom = Request::input('prenom');
        $lecteur->rue = Request::input('rue');
        $lecteur->cp = Request::input('cp');
        $lecteur->ville = Request::input('ville');
        $lecteur->save();
        return redirect('/home');
    }
}
