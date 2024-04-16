<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //direct Post page
    public function index(){
        $category = Category::get();
        $post = Post::get();
        return view('admin.post.index',compact('category','post'));
    }

    public function postCreate(Request $request){
        $validate = $this->postValidationCheck($request);
        if($validate->fails()){
            return back()->withErrors($validate)->withInput();
        }

        if(!empty($request->postImage)){
            $file = $request->file('postImage');
            $fileName = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/postImage',$fileName);

            $data = $this->getPostData($request,$fileName);
        }else{
            $data = $this->getPostData($request,NULL);
        }

        Post::create($data);

        return back();

    }

    //delete post
    public function postDelete($id){
        $postData = Post::where('post_id',$id)->first();
        $dbPostImage = $postData['image'];

        Post::where('post_id',$id)->delete();

        if(File::exists(public_path().'/postImage/'.$dbPostImage)){
            File::delete(public_path().'/postImage/'.$dbPostImage);
        }

        return back();
    }

    //direct edit page
    public function PostEditPage($id){
        $postDetail = Post::where('post_id',$id)->first();
        $post = Post::get();
        $category = Category::get();
        return view('admin.post.editPage',compact('postDetail','post','category'));
    }

    //update post
    public function updatePost($id,Request $request){
        $validate = $this->postValidationCheck($request);
        if($validate->fails()){
            return back()->withErrors($validate)->withInput();
        }

        $data = $this->updatePostData($request);

        //for image update
        if (isset($request->postImage)) {
            $this->storeNewImage($id,$request,$data);
        }else{
            Post::where('post_id',$id)->update($data);
        }

        return back();
    }

    //for image update
    private function storeNewImage($id,$request,$data){
        //get image data from client
        $file = $request->file('postImage');
        $fileName = uniqid().'_'.$file->getClientOriginalName();

        //database replace
        $data['image'] = $fileName;

        //get old image name to db
        $oldData = Post::where('post_id',$id)->first();
        $oldImageName = $oldData['image'];

        //delete old image from public folder
        if(File::exists(public_path().'/postImage/'.$oldImageName)){
            File::delete(public_path().'/postImage/'.$oldImageName);
        }

        //store new image under public folder
        $file->move(public_path().'/postImage',$fileName);

        //updat data
        Post::where('post_id',$id)->update($data);

    }

    //update post data
    private function updatePostData($request){
        return [
            'title' => $request->postTitle ,
            'description' => $request->postDescription ,
            'image' => $request->postImage ,
            'category_id' => $request->postCategory ,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    //get post data
    private function getPostData($request,$fileName){
        return [
            'title' => $request->postTitle ,
            'description' => $request->postDescription ,
            'image' => $fileName ,
            'category_id' => $request->postCategory ,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    private function postValidationCheck($request){
        return Validator::make($request->all(),[
            'postTitle' => 'required' ,
            'postDescription' => 'required' ,
            'postCategory' => 'required' ,
        ],[
            'postTitle.required' => 'Post Title is required!!',
            'postDescription.required' => 'Post Description is required!!',
            'postCategory.required' => 'Post Category is required!!'
        ]);
    }
}
