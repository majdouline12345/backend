<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(request $request){
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'image'=>'required|string|max:255',
        ]);
        $category = Category::create($data);
        return response()->json([
          'status'=>true,
          'message'=>'Category created.',
          'data'=> $category,
        ]);
    }
    public function index(Request $request){
        $categories = Category::all();
        return response()->json([
            'status'=>true,
            'message'=>'categories retrieved.',
            'data'=> $categories,
          ]);
    }
    public function show(Request $request,$id){
        $category = Category::find($id);
        return response()->json([
            'status'=>true,
            'message'=>'category found.',
            'data'=> $category,
          ]);
    }
    public function update(Request $request,$id){
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'image'=>'required|string|max:255',
        ]);
        $category = Category::find($id);
           if($category){
            $category->update($data);
            return response()->json([
                'status'=>true,
                'message'=>'category found.',
                'data'=> $category,
              ]);
        }
        else{
            return response()->json([
                'status'=>false,
                'message'=>'category not found.',
                'data'=> null,
              ], 404);
        }
    }
    public function delete(Request $request,$id){
       
        $category = Category::find($id);
           if($category){
            $category->delete;
            return response()->json([
                'status'=>true,
                'message'=>'category found.',
                'data'=> $category,
              ]);

        }
        else{
            
            return response()->json([
                'status'=>false,
                'message'=>'category not found.',
                'data'=> null,
              ], 404);
        }
    }
}
