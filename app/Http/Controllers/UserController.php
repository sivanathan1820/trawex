<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $valid = Validator::make($request->all(),
            [
                'firstname'     => 'required',
                'lastname'      => 'required',
                'email'         => 'required|email',
                'mobile'        => 'required',
                'address'       => 'required',
                'city'          => 'required',
                'country'       => 'required',
                'password'      => 'required',
                'c_password'    => 'required|same:password',
        ]);

        if($valid->fails())
        {
            return response()->json(['code' =>400,'message' => 'Invalid Input']);
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        $user   = User::create($data);
        $token  = $user->createToken('accessToken')->accessToken;

        return response()->json(['code' =>200,'message' => 'User Registered Successfully','token' => $token]);
    }

    public function login(Request $request)
    {
        $valid = Validator::make($request->all(),
            [
                'email'         => 'required|email',
                'password'      => 'required',
        ]);

        if($valid->fails())
        {
            return response()->json(['code' =>400,'message' => 'Invalid Input']);
        }

        if(!Auth::attempt(['email' => $request->email,'password' => $request->password]))
        {   
            return response()->json(['code' =>400,'message' => 'Invalid Credential']);
        }

        $user   = Auth::User();
        $token  = $user->createToken('accessToken')->accessToken;
        Session::put('token',$token);
        Session::put('isloged','yes');
        Session::put('logedid',$user->id);
        Session::put('logedfirstname',$user->firstname);
        Session::put('logedlastname',$user->lastname);
        Session::put('logedemail',$user->email);
        Session::put('logedmobile',$user->mobile);
        return response()->json(['code' =>200,'message' => 'You are logged in','token' => $token]);
    }

    public function logout()
    {
        if(Auth::check()) 
        {
            Session::flush();
            Auth::user()->token()->revoke();
            return response()->json(['code' => 200,'message' => 'You are logged out']);
        }
    }

    public function userslist()
    {
        $users = User::all();
        return response()->json(['code' => 200,'data' => $users]);
    }
}
