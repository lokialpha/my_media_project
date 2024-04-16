<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //get category
    public function category(){
        $category = Category::select('title','description','category_id')->get();
        return response()->json([
            'category' => $category
        ]);
    }

    //category search
    public function categorySearch(Request $request){
        $category = Category::select('posts.*')
                                ->join('posts','categories.category_id','posts.category_id')
                                ->where('categories.title','LIKE','%'.$request->key.'%')
                                ->get();
        return response()->json([
            'result' => $category
        ]);
    }
}
