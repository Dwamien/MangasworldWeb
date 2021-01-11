<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $table = 'commentaire';
    public $timestamps = false;
    protected $primaryKey = 'id_commentaire';
    protected $fillable = ['id_commentaire', 'lib_commentaire', 'id_manga', 'id_lecteur'];
    
    public function lecteur(){
        return $this->belongsTo('App\Models\Lecteur', 'id_lecteur', 'id_lecteur');
    }
    
    public function mangas(){
        return $this->hasMany('App\Models\Manga', 'id_manga', 'id_manga');
    }
}
