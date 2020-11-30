<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        //
    }
    public function login(Request $request){
        // dd($request->all());
        return $request->all();
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('username','ilike', strtolower($request->username))->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken(Str::random(10))->accessToken;
                $response = [
                    'message'   => 'Sukses',
                    'result'    =>  array(
                                        'token' => $token,
                                        'user'=> $user->only(['id', 'nama', 'username'])
                                    )
                ];
                return response($response, 200);
            } else {
                $response = ["message" => "Password Tidak Cocok"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User tidak ditemukan'];
            return response($response, 422);
        }
    }
    public function checkTokenIsActive(Request $request)
    {
        if (Auth::guard('api')->check()) {
            return response(["message" => 'Sukses'],200);
        }
        $response = ["message" => "Tidak login"];
        return response($response,422);
    }
}
