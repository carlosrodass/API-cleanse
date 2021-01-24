<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offers'; //Especificacion tabla correspondiente al modelo

    protected $fillable = [ //Estos campos solo van a ser accesibles para el admin
        'market_name',
        'offer_name',
        'points',
    ];
    

    //Relations
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
