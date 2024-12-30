<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class TestController extends Controller
{
    

    
    public function upload(Request $request){
      
        // dd($request->image);
 
    //    $request->image->store('/images');

    //    $data=new About();

    //    $path=$request->image;


    //    $data->image=$path->store('images/'.'date13');
    //    $data->save();


     Cart::instance('default')->add(1,'book',3,500); 
      
     return view('test.test');
     }
}
