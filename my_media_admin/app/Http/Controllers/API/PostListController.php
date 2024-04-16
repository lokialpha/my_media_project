<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostListController extends Controller
{
    //get post list
    public function postList(){
        $post = Post::get();
        return response()->json([
            'status' => 'success' ,
            'post' => $post
        ]);
    }

    //post search
    public function postSearch(Request $request){
        $searchData = Post::where('title','LIKE','%'.$request->key.'%')->get();
        return response()->json([
            'searchData' => $searchData
        ]);
    }

    //post detail
    public function postDetail(Request $request){
        $id = $request->postId;
        $post = Post::where('post_id',$id)->first();

        return response()->json([
            'post' => $post
        ]);
    }
}
