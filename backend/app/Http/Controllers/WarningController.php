<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Models\Unit;
use App\Models\Warning;

class WarningController extends Controller
{
    public function getMyWarnings(Request $request){
        $response = ["error" => ""];
        $property = $request->input("property");
        if($property){
            $user = auth()->user();
            $unit = Unit::where("id", $property)->where("id_owner", $user["id"])->count();
            if($unit > 0){
                $warnings = Warning::where("id_unit", $property)->orderBy("datecreated", "DESC")->orderBy("id", "DESC")->get();

                foreach($warnings as $warnKey => $warnValue){
                    $warnings[$warnKey]["datecreated"] = date("d/m/Y", strtotime($warnValue["datecreated"]));
                    $photoList = [];
                    $photos = explode(",", $warnValue["photos"]);
                    foreach($photos as $photo){
                        if(!empty($photo)){
                            $photoList[] = asset("storage/".$photo);
                        }
                    }
                    $warnings[$warnKey]["photos"] = $photoList;
                }

                $response["list"] = $warnings;
            } else {
                $response["error"] = "This unit is not yours.";
            }
        } else {
            $response["error"] = "This unit is not yours.";
        }

        return response()->json($response);
    }

    public function setWarning(Request $request){
        $response = ["error" => ""];
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "property" => "required"
        ]);
        if(!$validator->fails()){
            $newWarning = new Warning();
            $newWarning->id_unit = $request->input("property");
            $newWarning->title = $request->input("title");
            $newWarning->status = "IN_REVIEW";
            $newWarning->datecreated = date("Y-m-d");
            $newWarning->photos = "";
            if($request->input("list") && is_array($request->input("list"))){
                $photos = [];
                foreach($request->input("list") as $listItem){
                    $url = explode("/", $listItem);
                    $photos[] = end($url);
                }
                $newWarning->photos = implode(",", $photos);
            }
            $newWarning->save();
        } else {
            $response["error"] = $validator->errors()->first();
        }
        return response()->json($response);
    }

    public function addWarningFile(Request $request){
        $response = ["error" => ""];
        $validator = Validator::make($request->all(), [
            "photo" => "required|file|mimes:jpg,png"
        ]);
        if(!$validator->fails()){
            $file = $request->file("photo")->store("public");
            $response["photos"] = asset(Storage::url($file));
        } else {
            $response["error"] = $validator->errors()->first();
        }
        return response()->json($response);
    }
}
