<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\OwnerRestaurant;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OwnerRestaurantController extends Controller
{
    public function create(Request $request){
  $validator = Validator::make($request->all(), 
                      [ 
                      'restaurant_name' => 'required',
                      'restaurant_phone' => 'required' 
                     ]);  

         if ($validator->fails()) {  

               return response()->json(['error'=>$validator->errors()], 401); 

            }  

            $address=new Address();
            $address->x=$request->x;
            $address->y=$request->y;
            $address->address_name=$request->address_name;
            $address->save();

            $user= new User();
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->phone=$request->phone;
            $user->save();

            $owner_restaurant= new OwnerRestaurant();
            $owner_restaurant->restaurant_name=$request->restaurant_name;
            $owner_restaurant->restaurant_phone=$request->restaurant_phone;
            $owner_restaurant->user_id=$user->id;
            $owner_restaurant->address_id=$address->id;
            $owner_restaurant->save();

            if($owner_restaurant){
                return response()->json([
                    'massage'=>'data created successfully',
                    'date'=>$owner_restaurant
                ], 201);
            }




}


public function index()
{
    $owner_restaurants=OwnerRestaurant::all();
    return response()->json([
                    
                    'date'=>$owner_restaurants
                ], 200);
}


public function delete($id)  {

    $owner_restaurant=OwnerRestaurant::find($id);
    
    if($owner_restaurant){
         $owner_restaurant->delete();
          return ["message"=>"delete successfuly "];
    }
    
        return ["message"=>"id not found "];
    
    
}


public function search(Request $request)
{
   $owner_restaurant=OwnerRestaurant::where("restaurant_name","like","%".$request->restaurant_name."%")->first();

   return response()->json([
    'data'=>$owner_restaurant
   ]);
}


public function update($id, Request $request)
{
    $owner_restaurant=OwnerRestaurant::find($id);
    $owner_restaurant->restaurant_name=$request->restaurant_name;
    $owner_restaurant->restaurant_phone=$request->restaurant_phone;
    $resulte=$owner_restaurant->save();
    
}


}

