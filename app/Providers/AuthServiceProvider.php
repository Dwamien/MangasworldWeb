<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Manga;
use App\Policies\MangaPolicy;
use App\Models\Commentaire;
use App\Policies\CommentairePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        
        //ajout de la politique de sécurité sur le modèle App\Models\Manga
        //à la collection des politiques de sécurité
        
        'App/Model' => 'App\Policies\Policy', 
        Commentaire::class => CommentairePolicy::class, 
        
        'App/Model' => 'App\Policies\Policy', 
        Manga::class => MangaPolicy::class,  

                
    ];
    

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //vérifie que l'utilisateur dispose du rôle Contributeur
        Gate::define('contrib', function($user){
            return $user->role == 'contrib';
        });
        //vérifie que l'utilisateur dispose du rôle de Commentateur
        Gate::define('comment', function($user){
            return $user->role == 'comment';
        });
    }
}
