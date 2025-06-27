<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\OwnerRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MealController extends Controller
{
    public function createMeal(Request $request)
    {
         $validator = Validator::make($request->all(), 
                      [ 
                      'name' => 'required',
                      'photo' => 'required' ,
                      'price'=> ' required',
                      'category_id'=> ' required',
                      'description'=>'required'
                      
                     ]);  

         if ($validator->fails()) {  

               return response()->json(['error'=>$validator->errors()], 401); 

            }
            $meal = new Meal;
            $meal->name=$request->name;
            $meal->price=$request->price;
            if($request->hasFile('photo'))
            {
               $photoName=rand().time().'.'.$request->photo->getClientOriginalExtension();
               $path=$request->file('photo')->move('upload/', $photoName);
               $meal->photo=$photoName;
            }
            $user_id=Auth::user()->id;
            $owner_restaurant_id=OwnerRestaurant::where('user_id', $user_id)->value('id');
            $meal->owner_restaurant_id=$owner_restaurant_id;
            $meal->category_id=$request->category_id;
            $meal->description=$request->description;

            $meal->save();
            return response()->json(['data'=>$meal, 201]);

    }


    public function getMealByRestaurant($id)
    {
        $meals=Meal::select('id','name','price','photo', 'description')->where('owner_resturant_id',$id)->get();
        return response()->json([
            'data' => $meals
        ]);
    }


    public function getMealByRestaurantandCategory($owner_resturant_id,$category_id)
    {
        $owner_resturant=OwnerRestaurant::where('id',$owner_resturant_id)->first();
        $meals=$owner_resturant->categories()->where('categories.id',$category_id)->with('meals')->get();

        return response()->json(['data'=>$meals]);
    }


    public function searchMeal($restaurantId, $CategoryId , $mealName)
    {
        $meals=Meal::select('name','photo', 'price')->
        where('owner_resturant_id',$restaurantId)
        ->where('category_id',$CategoryId)->
        where('name','like','%'.$mealName.'%')->get();

        return response()->json(['data'=>$meals]);
    }

    
public function showDetailMeal($id)
{
    $meal = Meal::find($id);

    if ($meal) {
        return $meal;
    } else {
        return response()->json(['message' => 'The meal not found']);
    }
}

public function updateMeal(Request $request, $id)
{
    $meal = Meal::find($id);

    if ($meal) {
        if ($request->filled('name')) {
            $meal->name = $request->input('name');
        }

        if ($request->filled('price')) {
            $meal->price = $request->input('price');
        }

        if ($request->filled('category_id')) {
            $meal->category_id = $request->input('category_id');
        }

        if ($request->filled('description')) {
            $meal->description = $request->input('description');
        }

        if ($request->hasFile('photo')) {
            $photoName = rand() . time() . '.' . $request->photo->getClientOriginalExtension();
            $path = $request->file('photo')->move('upload/', $photoName);
            $meal->photo = $photoName;
        }

        $result = $meal->save();

        if ($result) {
            return ["Result" => "Data has been updated"];
        }

        return ["Result" => "Operation failed"];
    }

    return ["Result" => "Meal not found"];
}

public function delete($id)
{  
   $meal= Meal::find($id);
   $result=$meal->delete();
   if($result)
   {
    return ["Result"=>"data has been deleted"];
 }
 return ["Result"=>"operation failed"];

}


}
