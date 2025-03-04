<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesPaid extends Model
{
    use HasFactory;

    protected $table = 'collect_fees';

    //You have to change the tables in production

    protected $fillable = [
        'student_index_number',
        'student_name',
        // 'start_academic_year',
        // 'end_academic_year',
        // 'semester',
        'method_of_payment',
        'amount',
        'balance',
        'currency',
        'cheque_number',
        'Momo_number',
        // 'Fees',
        // 'remarks'
    ];
}

