<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElementActivite extends Model
{
    protected $fillable = ['activite_id', 'titre', 'description'];

    public function activite()
    {
        return $this->belongsTo(Activite::class);
    }
}
