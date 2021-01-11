<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Commentaire;
use App\Models\Manga;
use App\Models\Dessinateur;
use App\Models\Scenariste;
use App\Models\Genre;


class CommentaireController extends Controller
{
    public function getCommentaires($id){
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        $user = Auth::user();
        $commentaires = Commentaire::where('id_manga', $id)->get();
        $manga = Manga::find($id);
        return view('listeCommentaires', compact('commentaires', 'manga', 'user', 'erreur'));
    }
    
    public function updateCommentaire($id){
        $erreur = Session::get('erreur');
        Session::forget('erreur');        
        $readonly = null;
        $commentaire = Commentaire::find($id);
        $manga = Manga::find($commentaire->id_manga);
        /*$dessinateurs = Dessinateur::all();
        $genres = Genre::all();
        $scenaristes = Scenariste::all();*/
        $titreVue = "Modification d'un commentaire";
        $user = Auth::user();

        if(!$user->can('modifierComm', $commentaire)){
            $erreur ='Vous pouvez uniquement consulter ce commentaire, pas le modifier.';
            $readonly ='readonly';
        }
  
        return view('formCommentaire', compact('commentaire', 'manga', 'titreVue', 'user', 'erreur', 'readonly'));
    }
    
    public function showCommentaire($id){
        $erreur ='Vous pouvez uniquement consulter ce commentaire, pas le modifier.';
        $readonly = 'readonly';
        $commentaire = Commentaire::find($id);
        $manga = Manga::find($commentaire->id_manga);
        /*$dessinateurs = Dessinateur::all();
        $genres = Genre::all();
        $scenaristes = Scenariste::all();*/
        $titreVue = "Consultation d'un commentaire";
        $user = Auth::user();
        
        return view('formCommentaire', compact('commentaire', 'manga', 'titreVue', 'user', 'erreur', 'readonly'));
    }
    
    public function deleteCommentaire($id){
        
    try{
        $user = Auth::user();
        $commentaire = Commentaire::find($id);
            if(!$user->can('supprimer', $commentaire)){                
                $erreur = 'Vous ne disposez pas des droits pour supprimer ce commentaire!';
                Session::put('erreur', $erreur);
                return $this->getCommentaires($commentaire->id_manga);
            }
        $commentaire->delete();
        return redirect('/listerCommentaires/'.$commentaire->id_manga);
        } catch (Exception $ex) {
            $erreur = $ex->getMessage();
            Session::put('erreur', $erreur);
            return redirect('/listerCommentaires/'.$commentaire->id_manga);
        }
    }
    
    public function validateCommentaire(){
        $id_commentaire = Request::input('id_commentaire');
        $id_manga = Request ::input('id_manga');
        $lib_commentaire = Request::input('lib_commentaire');
        $user = Auth::user();
               
        if($id_commentaire > 0){
            $commentaire = Commentaire::find($id_commentaire);
        }else{
            $commentaire = new Commentaire();
        }
        
        $commentaire->lib_commentaire = $lib_commentaire;
        $commentaire->id_manga = $id_manga;
        $commentaire->id_lecteur = $user->id;        
        
        
        try{
            $commentaire->save();
        } catch (Exception $ex) {
            $erreur = $ex->getMessage();
            Session::put('erreur', $erreur);
            if($id_commentaire > 0){
                return redirect('/modifierCommentaire/'.$id_commentaire."/");
            }else{
                return redirect('/ajouterCommentaire/');
            }
        }
        return redirect('/listerCommentaires/'.$id_manga);
    }

    public function addCommentaire($id){
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        $user = Auth::user();
        $readonly = null;
        $commentaire = new Commentaire();
        $manga = Manga::find($id);
        /*$genres = Genre::all();
        $dessinateurs = Dessinateur::all();
        $scenaristes = Scenariste::all();*/
        $titreVue = "Ajout d'un Commentaire";
        
        return view('formCommentaire', compact('commentaire', 'manga','titreVue', 'user', 'erreur', 'readonly'));
    }    
}
