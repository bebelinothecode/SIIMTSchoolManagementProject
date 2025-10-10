<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $table = 'stock_out';

    protected $fillable = [
        'stock_id',
        'quantity_issued',
        'initial_quantity',
        'remaining_quantity',
        'issued_to',
        'notes',
        'date_issued',
        'date_returned',
        'issued_by',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
