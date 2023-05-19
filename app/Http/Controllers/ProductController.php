<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\User;
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
public function show(Request $request, $userId, $categoryId)
{
    $products = Product::where('category_id', $categoryId)->get();

    // Find the user
    $user = User::find($userId);

    // Check if the user exists
    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found.',
            'data' => null,
        ], 404);
    }

    // Retrieve the favorite products for the user
    $favoriteProducts = $user->favorites->pluck('id')->toArray();

    // Loop through each product and add 'favorited' property
    foreach ($products as $product) {
        $product->favorited = in_array($product->id, $favoriteProducts);
    }

    return response()->json([
        'status' => true,
        'message' => 'Products found.',
        'data' => $products,
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

    public function addToFavorites(Request $request, $userId, $productId)
{
    // Find the user
    $user = User::find($userId);

    // Check if the user exists
    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found.',
            'data' => null,
        ], 404);
    }

    // Find the product
    $product = Product::find($productId);

    // Check if the product exists
    if (!$product) {
        return response()->json([
            'status' => false,
            'message' => 'Product not found.',
            'data' => null,
        ], 404);
    }

    // Add the product to the user's favorites
    $user->favorites()->attach($product->id);

    return response()->json([
        'status' => true,
        'message' => 'Product added to favorites.',
        'data' => null,
    ]);
}
public function removeFromFavorites(Request $request, $userId, $productId)
{
    // Find the user
    $user = User::find($userId);

    // Check if the user exists
    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found.',
            'data' => null,
        ], 404);
    }

    // Find the product
    $product = Product::find($productId);

    // Check if the product exists
    if (!$product) {
        return response()->json([
            'status' => false,
            'message' => 'Product not found.',
            'data' => null,
        ], 404);
    }

    // Remove the product from the user's favorites
    $user->favorites()->detach($product->id);

    return response()->json([
        'status' => true,
        'message' => 'Product removed from favorites.',
        'data' => null,
    ]);
}

public function getFavoriteProducts($userId)
{
    // Find the user
    $user = User::find($userId);

    // Check if the user exists
    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found.',
            'data' => null,
        ], 404);
    }

    // Get the favorite products for the user
    $favoriteProducts = $user->favorites;

    return response()->json([
        'status' => true,
        'message' => 'Favorite products retrieved.',
        'data' => $favoriteProducts,
    ]);
}



}
