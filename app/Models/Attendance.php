<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'level',
        'lrn',
        'date',
        'time_in',
        'time_out',
        'status',
    ];

    public function student(){
        return $this->belongsTo(Student::class, 'lrn', 'lrn');
    }
}
