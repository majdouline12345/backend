<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;


use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'category_id' => 'required',
        'image' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'validation fails',
            'errors' => $validator->errors()
        ], 422);
    }

    $product = new Product();
    $product->category_id = $request->category_id;
    $product->image = $request->image;
    $product->save();

    return response()->json([
        'status' => true,
        'message' => 'product created.',
        'data' => $product,
    ]);
}
public function index(Request $request){
    // Retrieve all the products from the database
    $products = Product::all();
    
    // Return a JSON response with the status, message, and the data (products)
    return response()->json([
        'status'=>true,
        'message'=>'products retrieved.',
        'data'=> $products,
    ]);
}
    public function show(Request $request,$id){
        $product = Product::find($id);
        return response()->json([
            'status'=>true,
            'message'=>'product found.',
            'data'=> $product,
          ]);
    }
    public function update(Request $request,$id){
        $data = $request->validate([
            'id-category'=>'required|integer|max:255',
            'image'=>'required|string|max:255',
        ]);
        $product = Product::find($id);  
           if($product){
            $product->update($data);
            return response()->json([
                'status'=>true,
                'message'=>'product found.',
                'data'=> $product,
              ]);
        }
        else{
            return response()->json([
                'status'=>false,
                'message'=>'product not found.',
                'data'=> null,
              ], 404);
        }
    }
    public function delete(Request $request,$id){
       
        $product = Product::find($id);
           if($product){
            $product->delete;
            return response()->json([
                'status'=>true,
                'message'=>'product found.',
                'data'=> $product,
              ]);

        }
        else{
            
            return response()->json([
                'status'=>false,
                'message'=>'product not found.',
                'data'=> null,
              ], 404);
        }
    }
}
