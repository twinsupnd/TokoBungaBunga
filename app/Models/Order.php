<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'status', 'name', 'phone', 'address', 'total', 'paid_at'
    ];

    protected $dates = ['paid_at'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
