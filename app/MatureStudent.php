<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatureStudent extends Model
{
    protected $table = 'mature_students';

    use HasFactory;

    protected $fillable = [
        'name',
        'date_of_birth',
        'amount_paid',
        'mature_index_number',
        'course_id',
        'phone',
        'gender',
        'currency'
    ];

    public function course() 
    {
        return $this->belongsTo(Grade::class, 'course_id');
    }
}
