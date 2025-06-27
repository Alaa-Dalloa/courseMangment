<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable=[

        'price_after_discount',
        'end_date'

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

     public function owner_restaurant()
    {
        return $this->belongsTo(OwnerRestaurant::class);
    }

       public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_meal', 'meal_id', 'order_id')->withPivot('quantity','size');
    }
}
