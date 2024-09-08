<?php

namespace App\Models;

use App\Casts\DateTimeAmPmCast;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $casts = [
        'created_at' => DateTimeAmPmCast::class,
        'updated_at' => DateTimeAmPmCast::class,
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
