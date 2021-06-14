<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function getNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getAdminRevenueAttribute()
    {
        return $this->orderItems->sum(function(OrderItem $item ) {
            return $item->admin_revenue;
        });
    }

    public function getAmbassadorRevenueAttribute()
    {
        return $this->orderItems->sum(function(OrderItem $item) {
            return $this->ambassador_revenue;
        });
    }
}
