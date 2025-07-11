<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Meal;
use App\Models\Order;
use App\Models\OwnerRestaurant;
use App\Models\User;
use Carbon\Carbon;
use Hamcrest\Number\OrderingComparison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SendNotificationsService;

use App\Services\SendNotificationService; 


class OrderController extends Controller
{
   public function AddAddress(Request $request , $user_id)
   {
     $user=User::find($user_id);

     $address=new Address();
     $address->x=$request->x;
     $address->y=$request->y;
     $address->address_name=$request->address_name;
     $address->save();

     $user->addresses()->attach($address);
     return $address;
   }


    public function getOrcreateAddress(Request $request , $user_id)
    {
       if($request->has('address_id'))
       {
        $addressId=$request->address_id;
        $address=Address::find($addressId);
        if($address)
        {
            if($address->users()->where('user_id', $user_id)->exists())
            {
                return $address;
            }
        }
       }

       $address=$this->AddAddress($request, $user_id);
       $user=User::find($user_id);
       if(!$user->addresses()->where('address_id',$address->id)->exists())
       {
        $user->addresses()->attach($address);
       }
     
      return $address;

    }


  public function AddOrder(Request $request)
{
    $user = Auth::user();

    $status = 'Reciption';
    $order_date = Carbon::now();
    $delivery_cost = $request->delivery_cost;
    $user_id = $user->id;
    $order_price = 0;
    $address = $this->getOrcreateAddress($request, $user->id);

    $mealIds = collect($request->input('meal_ids'))->pluck('mealId')->toArray();

    $firstMeal = Meal::whereIn('id', $mealIds)->first();


    $owner_restaurant_id = $firstMeal->owner_restaurant_id;

    $order = Order::create([
        'delivery_cost' => $delivery_cost,
        'order_price' => $order_price,
        'order_date' => $order_date,
        'user_id' => $user->id,
        'address_id' => $address->id,
        'owner_restaurant_id' => $owner_restaurant_id
    ]);

    if ($request->has('meal_ids')) {
        foreach ($request->input('meal_ids') as $mealData) {
            $mealId = $mealData['mealId'];
            $quantity = $mealData['quantity'];
            $size = $mealData['size'];

            $meal = Meal::find($mealId);
            if ($meal) {
                $order->meals()->attach($meal, [
                    'quantity' => $quantity,
                    'size' => $size
                ]);

                $mealPrice = $meal->price_after_discount ?? $meal->price;

                if ($size == 'small') {
                  
                } elseif ($size == 'medium') {
                    $mealPrice += $mealPrice / 2;
                } elseif ($size == 'large') {
                    $mealPrice += $mealPrice * 2;
                }

                $order_price += $mealPrice * $quantity;
            }
        }
    }

    $order->update([
        'order_price' => $order_price
    ]);

   $user_id=OwnerRestaurant::where('id',$owner_restaurant_id)->value('user_id');
   $fcm_token=User::where('id',$user_id)->value('fcm_token');
   $message=[
    'title'=>'there are new notification order ',
    'body'=>$order->id
   ];

   (new SendNotificationService)->sendByFcm($fcm_token,$message);


    return response()->json(['data' => $order , 'fcm_token'=>$fcm_token , 'message'=>$message], 201);
}


   

}
