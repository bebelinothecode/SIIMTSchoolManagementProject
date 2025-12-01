<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherPayment extends Model
{
    protected $table = 'teacher_payments';

    protected $fillable = [
        'teacher_id',
        'receipt_number',
        'gross_amount',
        'withholding_tax',
        'net_amount',
        'method', //Cash/Mobile Money
        'session_ids',
        'paid_at',
        'already_paid'
    ];

    protected $casts = [
        'session_ids' => 'array',
        'paid_at' => 'datetime',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}