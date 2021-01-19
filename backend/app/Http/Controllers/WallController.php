<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Wall;
use App\Models\WallLike;
use App\Models\User;

class WallController extends Controller
{
    public function getAll(){
        $reponse = ["error" => "", "list" => []];
        $user = auth()->user();
        $walls = Wall::all();

        foreach($walls as $wallKey => $wallValue){
            $walls[$wallKey]["likes"] = 0;
            $walls[$wallKey]["liked"] = false;

            $likes = WallLike::where("id_wall", $wallValue["id"])->count();
            $walls[$wallKey]["likes"] = $likes;

            $meLikes = WallLike::where("id_wall", $wallValue["id"])->where("id_user", $user["id"])->count();
            if($meLikes > 0){
                $walls[$wallKey]["liked"] = true;
            }
        }

        $reponse["list"] = $walls;

        return response()->json($reponse);
    }

    public function like($id){
        $reponse = ["error" => ""];
        $user = auth()->user();
        $meLikes = WallLike::where("id_wall", $id)->where("id_user", $user["id"])->count();
        if($meLikes > 0){
            //Remove Like
            WallLike::where("id_wall", $id)->where("id_user", $user["id"])->delete();
            $reponse["liked"] = false;
        } else {
            //Add Like
            $newLike = new WallLike();
            $newLike->id_wall = $id;
            $newLike->id_user = $user["id"];
            $newLike->save();
            $reponse["liked"] = true;
        }
        $reponse["likes"] = WallLike::where("id_wall", $id)->count();
        return response()->json($reponse);
    }
}
