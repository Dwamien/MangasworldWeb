<?php

namespace App\Http\Controllers;

use Request;
use Exception;
use Session;
use Validator;
use App\Models\Manga;
use App\Models\Genre;
use App\Models\Dessinateur;
use App\Models\Scenariste;
use Illuminate\Support\Facades\Auth;

class MangaController extends Controller
{
    public function getMangas(){
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        $user = Auth::user();
        $mangas = Manga::all();
        return view('listeMangas', compact('mangas','erreur', 'user'));
    }

    public function getMangasGenre(){
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        $user = Auth::user();
        $id_genre = Request::input('cbGenre');

        if($id_genre){
        $mangas = Manga::where('id_genre', $id_genre)->get();
        return view('listeMangas', compact('mangas', 'erreur', 'user'));
        }else{
            $erreur = "Il faut sélectionner un genre ! ";
            Session::put('erreur', $erreur);
            return redirect('/listerGenres');
        }
    }

    public function updateManga($id){
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        $user = Auth::user();
        $readonly = null;
        $manga = Manga::find($id);
        $genres = Genre::all();
        $dessinateurs = Dessinateur::all();
        $scenaristes = Scenariste::all();
        $titreVue = "Modification d'un Manga";

        if (!$user->can('modifier', $manga)){
            $erreur = "Vous ne pouvez modifier que les mangas que vous avez créés ! ";
            $readonly = 'readonly';
        }
        return view('formManga', compact('manga', 'genres', 'dessinateurs', 'scenaristes', 'titreVue', 'erreur', 'user', 'readonly'));
    }

    public function validateManga(){
        $id_manga = Request::input('id_manga');
        $user = Auth::user();

        $regles = array(
            'titre' => 'required',
            'prix' => 'required | numeric',
            'cbScenariste' => 'required',
            'cbGenre' => 'required',
            'cbDessinateur' => 'required'
        );

        $messages = array(
            'titre.required' => 'Il faut saisir un titre.',
            'prix.required' => 'Il faut saisir un prix.',
            'prix.numeric' => 'Le prix doit être une valeur numérique, saisie avec un . et sans devise (€)',
            'cbScenariste.required' => 'Il faut saisir un scénariste.',
            'cbGenre.required' => 'Il faut saisir un genre.',
            'cbDessinateur.required' => 'Il faut saisir un dessinateur.'
        );

        $validator = Validator::make(Request::all(), $regles, $messages);

        if($validator->fails()){
            if($id_manga > 0){
                return redirect('modifierManga/'.$id_manga)
                        ->withErrors($validator)
                        ->withInput();
            }else{
                return redirect('ajouterManga/')
                        ->withErrors($validator)
                        ->withInput();
            }
        }

        $id_genre = Request::input('cbGenre');
        $id_scenariste = Request::input('cbScenariste');
        $id_dessinateur = Request::input('cbDessinateur');
        $titre = Request::input('titre');
        $prix = Request::input('prix');

        if(Request::hasFile('couverture')){
            $image = Request::file('couverture');
            $couverture = $image->getClientOriginalName();
            Request::file('couverture')->move(base_path().'/public/images/', $couverture);
        }else{
            $couverture = Request::input('couvertureHidden');
        }

        if($id_manga > 0){
            $manga = Manga::find($id_manga);
        }else{
            $manga = new Manga();
        }

        $manga->id_genre = $id_genre;
        $manga->id_scenariste = $id_scenariste;
        $manga->id_dessinateur = $id_dessinateur;
        $manga->titre = $titre;
        $manga->prix = $prix;
        $manga->couverture = $couverture;
        $manga->id_lecteur = $user->id;

        try{
            $manga->save();
        } catch (Exception $ex) {
            $erreur = $ex->getMessage();
            Session::put('erreur', $erreur);
            if($id_manga > 0){
                return redirect('/modifierManga'.$id_manga."/");
            }else{
                return redirect('/ajouterManga');
            }
        }
        return Redirect::route('listMang', 'MangaController@getMangas');
    }

    public function addManga(){
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        $user = Auth::user();
        $readonly = null;
        $manga = new Manga();
        $genres = Genre::all();
        $dessinateurs = Dessinateur::all();
        $scenaristes = Scenariste::all();
        $titreVue = "Ajout d'un Manga";

        return view('formManga', compact('manga', 'genres', 'dessinateurs', 'scenaristes', 'titreVue', 'erreur', 'user', 'readonly'));
    }

    public function deleteManga($id){

        try{
            $user = Auth::user();
            $manga = Manga::find($id);
            if(!$user->can('supprimer', $manga)){
                $erreur = 'Vous ne disposez pas des droits pour supprimer ce Manga!';
                Session::put('erreur', $erreur);
                return $this->getMangas();
            }
            $manga->delete();
            return redirect('/listerMangas');
        } catch (Exception $ex) {
            $erreur = $ex->getMessage();
            Session::put('erreur', $erreur);
            return redirect('/listerMangas');
        }

    }

    public function showManga($id){
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        $readonly = 'readonly';
        $manga = Manga::find($id);
        $genres = Genre::all();
        $dessinateurs = Dessinateur::all();
        $scenaristes = Scenariste::all();
        $titreVue = "Consultation d'un Manga";
        //affiche le formulaire en lui fournissant les données à afficher
        return view('formManga', compact('manga', 'genres', 'dessinateurs', 'scenaristes', 'titreVue', 'erreur', 'readonly'));
    }
}
