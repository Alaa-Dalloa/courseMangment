<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

     public function owner_restaurants()
   {
    return $this->belongsToMany(OwnerRestaurant::class , 'owner_category' , 'category_id' ,'owner_restaurant_id');
   }

}
