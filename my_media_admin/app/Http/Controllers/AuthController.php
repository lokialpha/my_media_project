<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //login
    public function login(Request $request){
        //need email and pwd
        $userData = User::where('email',$request->email)->first();

        if(isset($userData)){
            if(Hash::check($request->password, $userData->password)){
                return response()->json([
                    'user' => $userData ,
                    'token' => $userData->createToken(time())->plainTextToken
                ]);
            }else{
                return response()->json([
                    'user' => null ,
                    'token' => null
                ]);
            }
        }else{
            return response()->json([
                'user' => null ,
                'token' => null
            ]);
        }
    }

    //register
    public function register(Request $request){
        $data = [
            'name' => $request->name ,
            'email' => $request->email ,
            'password' => Hash::make($request->password)
        ];
        User::create($data);

        $userData = User::where('email',$request->email)->first();
        return response()->json([
            'user' => $userData ,
            'token' => $userData->createToken(time())->plainTextToken
        ]);
    }

    public function category(){
        $category = Category::get();
        return response()->json([
            'category' => $category
        ]);
    }
}
