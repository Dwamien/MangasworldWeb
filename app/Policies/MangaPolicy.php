<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Manga;

class MangaPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function modifier(User $user, Manga $manga) {
        $authorized = ($user->role == 'contrib' && $user->id == $manga->id_lecteur);
        return $authorized;
    }
    
    public function supprimer(User $user, Manga $manga) {
        $authorized = ($user->role == 'contrib' && $user->id == $manga->id_lecteur);
        return $authorized;
    }    
}
