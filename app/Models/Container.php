<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;

    protected $table = 'containers'; //Especificacion tabla correspondiente al modelo

    protected $fillable = [ //Estos campos solo van a ser accesibles para el admin
        'street_number',
        'street_name',
    ];


    //Relations
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
