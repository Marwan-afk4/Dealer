<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FilesController extends Controller
{

    public function getallFiles(){
        $files = File::all();
        return response()->json(['files'=>$files]);
    }

    public function addFile(Request $request){
        $validation = Validator::make($request->all(), [
            'file'=>'required|mimes:pdf',
        ]);
        if($validation->fails()){
            return response()->json(['error'=>$validation->errors()],401);
        }

        if($request->file('file')->isValid()){
            $file = $request->file('file');
            $file_name = time().$file->getClientOriginalName();
            $filepath = $file->storeAs('files', $file_name);

            $fileModel = new File();
            $fileModel->name = $file_name;
            $fileModel->path = $filepath;
            $fileModel->save();
            return response()->json([
                'success'=>true,
                'message'=>'File Added Successfully',
                'data' =>[
                    'id'=>$fileModel->id,
                    'name'=>$fileModel->name,
                    'path'=>Storage::url($fileModel->path),
                ]
            ]
            ,200);
        }
        else{
            return response()->json(['success' => false, 'message' => 'File upload failed.'], 500);
        }
    }

    public function deleteFile($id){
        $file = File::find($id);
        $file->delete();
        return response()->json(['message'=>'File deleted successfully']);
    }
}
