<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Level extends Model
{
    use Notifiable;

    protected $fillable = [
        'level'
    ];
}
