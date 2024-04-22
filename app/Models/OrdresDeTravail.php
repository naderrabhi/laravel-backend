<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdresDeTravail extends Model
{
    use HasFactory;

    protected $table = 'ordres_de_travail';

    protected $fillable = [
        'utilisateur_id',
        'equipement_id',
        'titre',
        'description',
        'priorite',
        'statut',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "utilisateur_id");
    }

    public function equipement()
    {
        return $this->belongsTo(Equipements::class, "equipement_id");
    }

    public function affectaionDesOrdres()
    {
        return $this->hasMany(AffectaionDesOrdres::class, 'ordre_travail_id');
    }
}
