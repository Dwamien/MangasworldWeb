<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Commentaire;

class CommentairePolicy
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

    public function modifierComm(User $user, Commentaire $commentaire) {
        $authorized = ($user->role == 'comment' && $user->id == $commentaire->id_lecteur);
        return $authorized;
    }
    
    public function supprimerComm(User $user, Commentaire $commentaire) {
        $authorized = ($user->role == 'comment' && $user->id == $commentaire->id_lecteur);
        return $authorized;
    }   
}
