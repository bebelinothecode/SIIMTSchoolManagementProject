<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canteen extends Model
{
    use HasFactory;

    protected $table = 'canteen';

    protected $fillable = [
        'item_name',
        'description',
        'amount',
        'category',
        'mode_of_transaction',
        'branch',
        'currency',
    ];
}
