<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOffer extends Model
{
    use HasFactory;
    protected $table = 'offer__users'; //Especificacion tabla correspondiente al modelo

    protected $fillable = [ //Estos campos solo van a ser accesibles para el admin
        'offer_id',
        'user_id',
        'points',
    ];
}
