<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\OwnerRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

public function create(Request $request){
  $validator = Validator::make($request->all(), 
                      [ 
                      'name' => 'required',
                      'photo' => 'required' 
                     ]);  

         if ($validator->fails()) {  

               return response()->json(['error'=>$validator->errors()], 401); 

            }  

            $category=new Category();
            $category->name=$request->name;
            if($request->hasFile('photo'))
           {
            $photoName=rand().time().'.'.$request->photo->getClientOriginalExtension();
            $path=$request->file('photo')->move('upload/', $photoName );
            $category->photo=$photoName ;
           }
            $category->photo=$photoName;
            $category->save();


            $user_id=Auth::user()->id;
            $owner_restaurant=OwnerRestaurant::where('user_id',$user_id)->first();
            $category->owner_restaurants()->attach($owner_restaurant);

            return response()->json($category, 201);
}


}



