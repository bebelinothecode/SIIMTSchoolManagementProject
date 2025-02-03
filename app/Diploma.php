<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diploma extends Model
{
    protected $table = 'diploma';

    protected $fillable = [
        'type_of_course',
        'code',
        'name',
        'duration',
        'currency',
        'fees'
    ];

    use HasFactory;
}
