<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Validator;
use Response;

class ProductController extends Controller
{
    
    public function index()
    {
        //Get all the data from database
        $products = Products::all();
        return response()->json($products);
    }

    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //Post data to DB from User
        $this->validate($request,[
            'title'=> 'required',
            'price'=> 'required',
            'photo'=> 'required',
            'description'=> 'required'
        ]);

        $product = new Products();
        //Image Data
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $allowedFileExtension = ['png','jpg'];
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension, $allowedFileExtension);

            if($check){
                $name = time(). $file->getClientOriginalName();
                $file->move('images', $name);
                $product->photo = $name;
            }
        }

        //Text data
        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        $product->save();

        return response()->json($product);
    }

   
    public function show($id)
    {
        //give single item from product table
        $products = Products::find($id);
        return response()->json($products);
    }

    
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //Update -> id
        $this->validate($request,[
            'title'=> 'required',
            'price'=> 'required',
            'photo'=> 'required',
            'description'=> 'required'
        ]);

        $product = Products::find($id);

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $allowedFileExtension = ['png','jpg','webp'];
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension, $allowedFileExtension);

            if($check){
                $name = time(). $file->getClientOriginalName();
                $file->move('images', $name);
                $product->photo = $name;
            }
        }

        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        $product->save();

        return response()->json($product);
    }

    
    public function destroy($id)
    {
        //Delete -> ID
        $product = Products::find($id);
        $product->delete();
        return response()->json('Product Deleted Successfully!');
    }
}
