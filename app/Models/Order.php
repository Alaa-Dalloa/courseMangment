<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
    'status',
    'order_price',
    'delivery_cost',
    'user_id',
    'order_date',
    'address_id',
    'owner_restaurant_id'
    ];

     public function address()
   {
    return $this->belongsTo(Address::class);
   }

     public function user()
   {
    return $this->belongsTo(User::class);
   }

   public function owner_restaurant()
    {
        return $this->belongsTo(OwnerRestaurant::class);
    }

    
   public function meals()
    {
        return $this->belongsToMany(Meal::class,'order_meal', 'order_id', 'meal_id')->withPivot('quantity','size');
    }

}
