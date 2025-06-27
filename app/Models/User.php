<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    
  

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

   public function roles()
   {
    return $this->belongsToMany(Role::class , 'role_user' , 'user_id' ,'role_id');
   }

    public function owner_restaurant()
    {
        return $this->hasOne(OwnerRestaurant::class);
    }

    public function hasRole($RoleName)
    {
        return $this->roles()->where('name',$RoleName)->exists();
    }
    public function orders()
   {
       return $this->hasMany(Order::class);
   }
       public function addresses()
{
    return $this->belongsToMany(Address::class, 'address_user', 'user_id', 'address_id');
}
}