<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerRestaurant extends Model
{
    use HasFactory;
   
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function meals()
    {
        return $this->hasMany(Meal::class);
    }
     public function categories()
   {
    return $this->belongsToMany(Category::class , 'owner_category' , 'category_id' ,'owner_restaurant_id');
   }

}
