<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rodovia extends Model
{
    protected $table = 'rodovias'; 
    protected $fillable = ['rodovia'];

    public function trechos()
    {
        return $this->hasMany(Trecho::class);
    }
}
