<?php

namespace App\Models;

use App\Casts\DateTimeAmPmCast;
use Illuminate\Database\Eloquent\Model;

class ProductLog extends Model
{
    protected $casts = [
        'created_at' => DateTimeAmPmCast::class,
    ];

    protected $fillable = ['product_id', 'quantity_change', 'operation', 'quantity_after_change', 'quantity_before_change'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
