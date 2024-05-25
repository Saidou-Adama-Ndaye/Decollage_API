<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    protected $fillable = ['nom', 'description'];

    public function elementsActivites()
    {
        return $this->hasMany(ElementActivite::class);
    }
}
