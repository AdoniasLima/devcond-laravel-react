<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Unit;

class AuthController extends Controller
{
    public function unauthorized(){
        return response()->json([
            "error" => "Not authorized"
        ], 401);
    }

    public function register(Request $request){
        $response = ["error" => ""];
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "cpf" => "required|digits:11|unique:users,cpf",
            "password" => "required",
            "password_confirm" => "required|same:password"
        ]);
        if(!$validator->fails()){
            $name = $request->input("name");
            $email = $request->input("email");
            $cpf = $request->input("cpf");
            $password = $request->input("password");
            $hash = password_hash($password, PASSWORD_DEFAULT);
            
            $newUser = new User();
            $newUser->name = $name;
            $newUser->email = $email;
            $newUser->cpf = $cpf;
            $newUser->password = $hash;
            $newUser->save();
            
            $token = auth()->attempt([
                "cpf" => $cpf,
                "password" => $password
            ]);

            if(!$token){
                $response["error"] = "An error has occurred.";
            }

            $response["token"] = $token;

            $user = auth()->user();
            $response["user"] = $user;

            $properties = Unit::select(["id", "name"])->where("id_owner", $user["id"]);
            $response["user"]["properties"] = $properties;
        } else {
            $response["error"] = $validator->errors()->first();
        }
        return response()->json($response);
    }

    public function login(Request $request){
        $response = ["error" => ""];
        $validator = Validator::make($request->all(),[
            "cpf" => "required|digits:11",
            "password" => "required"
        ]);
        if(!$validator->fails()){
            $cpf = $request->input("cpf");
            $password = $request->input("password");
            $token = auth()->attempt([
                "cpf" => $cpf,
                "password" => $password
            ]);

            if(!$token){
                $response["error"] = "CPF and/or password are wrong.";
            }

            $response["token"] = $token;

            $user = auth()->user();
            $response["user"] = $user;

            $properties = Unit::select(["id", "name"])->where("id_owner", $user["id"]);
            $response["user"]["properties"] = $properties;            
        } else {
            $response["error"] = $validator->errors()->first();
        }
        return response()->json($response);
    }

    public function validateToken(){
        $response = ["error" => ""];
        $user = auth()->user();
        $response["user"] = $user;
        $properties = Unit::select(["id", "name"])->where("id_owner", $user["id"]);
        $response["user"]["properties"] = $properties;
        return response()->json($response);
    }

    public function logout(){
        $response = ["error" => ""];
        auth()->logout();
        return response()->json($response);
    }
}
