<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';

    protected $fillable = [
        'transaction_type', // e.g., 'issue' or 'return'
        'user_name',
        'quantity',
        'notes',
        'issue_date',
        'return_date',
        'stock_id',
    ];

     public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
