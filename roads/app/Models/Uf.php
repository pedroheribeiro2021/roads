<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    protected $table = 'ufs'; 
    protected $fillable = ['uf']; 

    public function trechos()
    {
        return $this->hasMany(Trecho::class);
    }
}
