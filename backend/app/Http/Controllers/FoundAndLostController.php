<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\FoundAndLost;

class FoundAndLostController extends Controller
{
    public function getAll(){
        $response = ["error" => ""];
        
        //Lost items
        $lost = FoundAndLost::where("status", "LOST")->orderBy("datecreated", "DESC")->orderBy("id", "DESC")->get();
        foreach($lost as $lostKey => $lostValue){
            $lost[$lostKey]["datecreated"] = date("d/m/Y", strtotime($lostValue["datecreated"]));
            $lost[$lostKey]["photo"] = asset("storage/".$lostValue["photo"]);
        }
        //Recovered items
        $recovered = FoundAndLost::where("status", "RECOVERED")->orderBy("datecreated", "DESC")->orderBy("id", "DESC")->get();
        foreach($recovered as $recoveredKey => $recoveredValue){
            $recovered[$recoveredKey]["datecreated"] = date("d/m/Y", strtotime($recoveredValue["datecreated"]));
            $recovered[$recoveredKey]["photo"] = asset("storage/".$recoveredValue["photo"]);
        }
        
        $response["lost"] = $lost;
        $response["recovered"] = $recovered;
        
        return response()->json($response);
    }

    public function insert(Request $request){
        $response = ["error" => ""];
        $validator = Validator::make($request->all(), [
            "description" => "required",
            "location" => "required",
            "photo" => "required|file|mimes:jpg,png"
        ]);
        if(!$validator->fails()){
            $newFoundAndLost = new FoundAndLost();
            $newFoundAndLost->description = $request->input("description");
            $newFoundAndLost->location = $request->input("location");
            $file = $request->file("photo")->store("public");
            $file = explode("public/", $file);
            $newFoundAndLost->photo = $file[1];
            $newFoundAndLost->status = "LOST";
            $newFoundAndLost->datecreated = date("Y-m-d");
            $newFoundAndLost->save();
        } else {
            $response["error"] = $validator->errors()->first();
        }
        return response()->json($response);
    }

    public function update($id, Request $request){
        $response = ["error" => ""];
        $status = $request->input("status");
        $status = strtoupper($status);
        if($status && in_array($status, ["LOST", "RECOVERED"])){
            $item = FoundAndLost::find($id);
            if($item){
                $item->status = $status;
                $item->save();
            } else {
                $response["error"] = "Item nod found";
            }
        }
        return response()->json($response);
    }
}
