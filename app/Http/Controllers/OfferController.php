<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function addOffer($mealId, Request $request)
    {

        $meal=Meal::find($mealId);

        if(!$meal)
        {
             return response()->json(['message'=> ' meal not found'], 404);
        }

        $meal->update([
            'price_after_discount'=>$request->price_after_discount,
            'end_date'=>$request->end_date
        ]);
        
        
        $currentDate=Carbon::now();
        if($currentDate >$request->end_date)
        {
            return response()->json(['message'=> ' End date should be greater than current date']);
        }

        if($request->price_after_discount >= $meal->price)
        {
        return response()->json(['message'=> ' price_after_discount should be less than current price']);
        }

       
         return response()->json(['data'=> $meal]);
    }



    public function getOffers($restaurantId)
    {
        $meals=Meal::where('owner_resturant_id',$restaurantId)
        ->whereNotNull('price_after_discount')
        ->first();
         return response()->json(['data'=> $meals]);

    }


    public function deleteOffer($mealId)
{
    $meal = Meal::find($mealId);
    $meal->end_date = 'null';
    $meal->price_after_discount = 'null';
    $meal->save();
    return response()->json("offer has been deleted successfully");
}


public function editOffer($mealId,Request $request)
{
    $meal = Meal::find($mealId);
    $price_after_discount = $request->input('price_after_discount');
    $end_date = $request->input('end_date');

    if (!$meal) {
        return response()->json("Meal not found", 404);
    }
    $currentDate = Carbon::now()->tz('Europe/London')->addHours(3);
     if ($end_date <= $currentDate) {
        return response()->json("End date should be greater than the current date", 422);
    }
     if ($price_after_discount >= $meal->price) {
        return response()->json("New price should be less than the current price of the meal", 422);
    }
    $meal->price_after_discount = $price_after_discount;
    $meal->end_date = $end_date;
    $meal->save();

    return response()->json("Offer updated to the meal successfully");
}



}
