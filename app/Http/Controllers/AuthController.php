<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password) ;
        $user->save();
        $res = [];
        $res['token']=$user->createToken('PersonalToken')->accessToken;
        $res['name']=$user->name;
        return response()->json($res, 200);
    }

    public function login(Request $request)
    {
        $data = request(['email','password']);
        if(Auth::attempt($data)){
            $user = Auth::user();
            $res = [];
            $res['token']=$user->createToken('PersonalToken');
            $res['name']=$user->name;
            return response()->json($res, Response::HTTP_OK);
        }
        return response()->json("Unauth", Response::HTTP_UNAUTHORIZED);
    }

}
