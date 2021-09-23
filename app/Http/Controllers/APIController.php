<?php

namespace App\Http\Controllers;

use App\PierMigration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class APIController extends Controller
{
    public function resource($model, $rowId = null, Request $request){
        if(!is_null($rowId)){
            $res = PierMigration::detail($model, $rowId, $request->input());
            return response()->json($res);
        }
        else{
            $res = PierMigration::browse($model, $request->input());
            return response()->json($res);
        }   
    }
    
    public function searchResource($model){
        $res = PierMigration::search($model, $_GET['q']);
        return response()->json($res);
    }
    
    public function createResource($model, Request $request){
        $res = PierMigration::insertRow($model, $request->all());
        return response()->json($res);
    }

    public function updateResource($model, $rowId, Request $request){
        $res = PierMigration::updateRow($model, $rowId, $request->all());
        return response()->json($res);
    }
    
    public function deleteResource($model, $rowId){
        $res = PierMigration::deleteEntry($model, $rowId);
        return response()->json($res);
    }

    public function upload_file($model, Request $request){
        $folder_name = Str::snake($model);
        $file = $request->file('photo');
        $imageNameExt = $file->getClientOriginalName();
        $imageName = pathinfo($imageNameExt,PATHINFO_FILENAME);
        $imageNameStore = $imageName . '_' . time() . '.' . pathinfo($imageNameExt, PATHINFO_EXTENSION);
        $path = $file->storeAs("public/$folder_name/", $imageNameStore);

        return response()->json([
            "success" => true, 
            "path" => asset(str_replace("public", "storage", $path))
        ]);
    }
}
