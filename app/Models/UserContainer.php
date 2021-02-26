<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContainer extends Model
{
    use HasFactory;
    protected $table = 'user__containers'; //Especificacion tabla correspondiente al modelo

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'container_id',
        'points',
        'trash_kilograms'
    ];
}
