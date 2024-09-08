<?php

namespace App\Models;

use App\Casts\DateTimeAmPmCast;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $casts = [
        'created_at' => DateTimeAmPmCast::class,
        'updated_at' => DateTimeAmPmCast::class,
    ];

    protected $fillable = ['name', 'quantity'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function logs()
    {
        return $this->hasMany(ProductLog::class);
    }

    public function incrementQuantity(int $amount)
    {
        $quantity_before_change = $this->quantity ? $this->quantity : 0;
        $this->increment('quantity', $amount);

        $this->logs()->create([
            'quantity_change' => $amount,
            'operation' => 'increment',
            'quantity_before_change' => $quantity_before_change,
            'quantity_after_change' => $this->quantity
    ]);
    }

    public function decrementQuantity(int $amount)
    {
        if ($this->quantity >= $amount) {
            $quantity_before_change = $this->quantity ? $this->quantity : 0;
            $this->decrement('quantity', $amount);

            $this->logs()->create([
                'quantity_change' => -$amount,
                'operation' => 'decrement',
                'quantity_before_change' => $quantity_before_change,
                'quantity_after_change' => $this->quantity
            ]);
        } else {
            throw new \Exception('Insufficient quantity to decrement.');
        }
    }
}
