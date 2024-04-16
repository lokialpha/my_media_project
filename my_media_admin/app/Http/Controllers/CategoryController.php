<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    ///direct category page
    public function index(){
        $category = Category::get();
        return view('admin.category.index',compact('category'));
    }

    //create category
    public function createCategory(Request $request){
        $validator = $this->categoryValidationCheck($request);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        };

        $data = $this->categoryGetData($request);
        Category::create($data);
        return back();
    }

    // delete category
    public function deleteCategory($id){
        Category::where('category_id',$id)->delete();
        return redirect()->route('admin#category')->with(['deleteSuccess'=>'Category Delete Success!!']);
    }

    //search category
    public function categorySearch(Request $request){
        $category = Category::orWhere('category_id','LIKE','%'.$request->categorySearchKey.'%')
                                ->orWhere('category_id','LIKE','%'.$request->categorySearchKey.'%')
                                ->orWhere('title','LIKE','%'.$request->categorySearchKey.'%')
                                ->orWhere('description','LIKE','%'.$request->categorySearchKey.'%')
                                ->get();
        return view('admin.category.index',compact('category'));
    }

    //direct category edit page
    public function categoryEditPage($id){
        $category = Category::get();
        $data = Category::where('category_id',$id)->first();
        return view('admin.category.edit',compact('data','category'));
    }

    //category update
    public function categoryUpdate($id,Request $request){
        $validator = $this->categoryValidationCheck($request);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        };

        $updateData = $this->categoryUpdateData($request);
        Category::where('category_id',$id)->update($updateData);
        return redirect()->route('admin#category');
    }

    //get category update data
    private function categoryUpdateData($request){
        return [
            'title' => $request->categoryName ,
            'description' => $request->categoryDescription ,
        ];
    }

    //get category data
    private function categoryGetData($request){
        return [
            'title' => $request->categoryName ,
            'description' => $request->categoryDescription ,
        ];
    }

    //categoryValidationCheck
    private function categoryValidationCheck($request){
        return Validator::make($request->all(), [
            'categoryName' => 'required',
            'categoryDescription' => 'required',
        ],[
            'categoryName.required' => 'Category Name is required!!',
            'categoryDescription.required' => 'Category Description is required!!'
        ]);
    }
}
