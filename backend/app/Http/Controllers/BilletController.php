<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Billet;
use App\Models\Unit;

class BilletController extends Controller
{
    public function getAll(Request $request){
        $response = ["error" => ""];
        $property = $request->input("property");
        if($property){
            $user = auth()->user();
            $unit = Unit::where("id", $property)->where("id_owner", $user["id"])->count();
            if($unit > 0){
                $billets = Billet::where("id_unit", $property)->get();
                foreach($billets as $billetsKey => $billetsValue){
                    $billets[$billetsKey]["fileurl"] = asset("storage/".$billetsValue["fileurl"]);
                }
                $response["list"] = $billets;
            } else {
                $response["error"] = "This unit is not yours.";
            }

        } else {
            $response["error"] = "Property not informed.";
        }
        return response()->json($response);
    }
}
