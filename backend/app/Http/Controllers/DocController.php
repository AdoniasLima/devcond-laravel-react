<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Doc;

class DocController extends Controller
{
    public function getAll(){
        $response = ["error" => ""];
        $docs = Doc::all();
        foreach($docs as $docKey => $docValue){
            $docs[$docKey]["fileurl"] = asset("storage/".$docValue["fileurl"]);
        }
        $response["list"] = $docs;
        return response()->json($response);
    }
}
