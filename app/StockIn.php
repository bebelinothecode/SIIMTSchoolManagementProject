<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $table = 'stock_in';

    protected $fillable = [
        'stock_id',
        'new_stock_in_quantity',
        'old_stock_in_quantity',
        'total_stock_after_in',
        'notes',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
