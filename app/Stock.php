<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';

    protected $fillable = [
        'stock_name',
        'quantity',
        'description',
        'location',
        'unit_of_measure',
        // 'recipient',
        // 'date_out',
        // 'date_in',
    ];

    /**
     * Get all stock-in records for the product
     */
    public function stockIns(): HasMany
    {
        return $this->hasMany(StockIn::class);
    }

     /**
     * Get all stock-out records for the product
     */
    public function stockOuts(): HasMany
    {
        return $this->hasMany(StockOut::class);
    }
}
