<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public function owner_restaurant()
    {
        return $this->hasOne(OwnerRestaurant::class);
    }

     public function orders()
   {
       return $this->hasMany(Order::class);
   }

      public function users()
 {
    return $this->belongsToMany(User::class, 'address_user', 'address_id', 'user_id');
 }
}
