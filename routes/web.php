<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// les routes d'authentification (se connecter, s'inscrire...)
Auth::routes();

// les routes publiques
// pages d'accueil
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
//afficher la liste de tous les mangas
Route::get('/listerMangas', [
    'as' => 'listMang',
    'uses' => 'MangaController@getMangas'
]);
//afficher la liste déroulante des genres
Route::get('/listerGenres', 'GenreController@getGenres');
//lister tous les mangas d'un genre sélectionné
Route::post('/listerMangasGenre', 'MangaController@getMangasGenre');
Route::get('/listerCommentaires/{id}', 'CommentaireController@getCommentaires');
Route::get('/consulterCommentaire/{id}', 'CommentaireController@showCommentaire');



//les routes protégées
Route::group(['middleware' => ['auth']], function(){
    //afficher la page de saisie pour l'ajout d'un manga
Route::get('/ajouterManga', 'MangaController@addManga')->middleware('can:contrib');
//enregistrer la mise à jour d'un manga
Route::post('/validerManga', 'MangaController@validateManga');
//supprimer le manga
Route::get('/supprimerManga/{id}', 'MangaController@deleteManga')->middleware('can:contrib');
//afficher un manga pour pouvoir éventuellement le modifier
Route::get('/modifierManga/{id}', 'MangaController@updateManga')->middleware('can:contrib');
Route::get('/profil', 'ProfilController@getProfil');
Route::post('/profil', 'ProfilController@setProfil');
Route::get('/consulterManga/{id}', 'MangaController@showManga')->middleware('can:comment');
Route::get('/modifierCommentaire/{id}', 'CommentaireController@updateCommentaire')->middleware('can:comment');
Route::get('/supprimerCommentaire/{id}', 'CommentaireController@deleteCommentaire')->middleware('can:comment');
Route::post('/validerCommentaire', 'CommentaireController@validateCommentaire');
Route::get('/ajouterCommentaire/{id}', 'CommentaireController@addCommentaire')->middleware('can:comment');
});

