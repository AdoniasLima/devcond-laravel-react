<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Unit;
use App\Models\UnitPeople;
use App\Models\UnitVehicle;
use App\Models\UnitPet;

class UnitController extends Controller
{
    public function getInfo($id){
        $response = ["error" => ""];
        $unit = Unit::find($id);
        if($unit){
            $people = UnitPeople::where("id_unit", $id)->get();
            $vehicles = UnitVehicle::where("id_unit", $id)->get();
            $pets = UnitPet::where("id_unit", $id)->get();

            foreach($people as $peopleKey => $peopleValue){
                $people[$peopleKey]["birthdate"] = date("d/m/Y", strtotime($peopleValue["birthdate"]));
            }

            $response["people"] = $people;
            $response["vehicles"] = $vehicles;
            $response["pets"] = $pets;
        } else {
            $response["error"] = "Unit not found";
        }
        return response()->json($response);
    }

    public function addPerson($id, Request $request){
        $response = ["error" => ""];
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "birthdate" => "required|date"
        ]);
        if(!$validator->fails()){
            $newUnitPeople = new UnitPeople();
            $newUnitPeople->id_unit = $id;
            $newUnitPeople->name = $request->input("name");
            $newUnitPeople->birthdate = $request->input("birthdate");
            $newUnitPeople->save();
        } else {
            $response["error"] = $validator->errors()->first();
        }
        return response()->json($response);
    }

    public function addVehicle($id, Request $request){
        $response = ["error" => ""];
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "color" => "required",
            "plate" => "required"
        ]);
        if(!$validator->fails()){
            $newVehicle = new UnitVehicle();
            $newVehicle->id_unit = $id;
            $newVehicle->title = $request->input("title");
            $newVehicle->color = $request->input("color");
            $newVehicle->plate = $request->input("plate");
            $newVehicle->save();
        } else {
            $response["error"] = $validator->errors()->first();
        }
        return response()->json($response);
    }

    public function addPet($id, Request $request){
        $response = ["error" => ""];
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "race" => "required"
        ]);
        if(!$validator->fails()){
            $newPet = new UnitPet();
            $newPet->id_unit = $id;
            $newPet->name = $request->input("name");
            $newPet->race = $request->input("race");
            $newPet->save();
        } else {
            $response["error"] = $validator->errors()->first();
        }
        return response()->json($response);
    }

    public function removePerson($id, Request $request){
        $response = ["error" => ""];
        $idItem = $request->input("id");
        if($idItem){
            UnitPeople::where("id", $idItem)->where("id_unit", $id)->delete();
        } else {
            $response["error"] = "ID not found";
        }
        return response()->json($response);
    }

    public function removeVehicle($id, Request $request){
        $response = ["error" => ""];
        $idItem = $request->input("id");
        if($idItem){
            UnitVehicle::where("id", $idItem)->where("id_unit", $id)->delete();
        } else {
            $response["error"] = "ID not found";
        }
        return response()->json($response);
    }

    public function removePet($id, Request $request){
        $response = ["error" => ""];
        $idItem = $request->input("id");
        if($idItem){
            UnitPet::where("id", $idItem)->where("id_unit", $id)->delete();
        } else {
            $response["error"] = "ID not found";
        }
        return response()->json($response);
    }
}
