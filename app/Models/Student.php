<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use Notifiable, HasFactory, SoftDeletes;


    protected $fillable = [
        'name',
        'age',
        'gender',
        'address',
        'lrn',
        'level',
        'guardian',
        'email',
        'qrCode',
    ];
}
