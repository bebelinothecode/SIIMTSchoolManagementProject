<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesType extends Model
{
    use HasFactory;

    protected $table = 'fees_type';

    protected $fillable = [
        'fees_type'
    ];
}
