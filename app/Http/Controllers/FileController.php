<?php

namespace App\Http\Controllers;

use App\File;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function getAll()
    {
        $files = File::all();

        return response()-> json([
            'files' => $files
        ], 200);
    }
    public function new(Request $request)
    {
       
        $validateData['files'] = $request->files; 
       
        $validator = Validator::make(
            $validateData,
            [
                'files' => 'required',
                'files.*' => 'required|image|file|max:3000',
            ],
            $messages = [
                'files.required' => 'Вы не добавили фото',
                'files.*.image' => 'Загруженный файл должен быть изображением в формате JPEG, PNG, BMP, GIF или SVG',
                'files.*.file' => 'Произошла ошибка при загрузке, попробуйте еще раз...',
                'files.*.max' => 'Загруженный файл должен быть не более 3 мегабайт',
            ]
        );
       

        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' =>  $validator->errors()->all()
            ]);

        } else {

            foreach($request->file('files') as $file) {
                
                $file = $file->store('public/files');

                $file = asset(Storage::url($file));

                File::create([
                   'src' => $file
                ]);
            }

            return response()->json([
                'status' => 'succcess'
            ], 200);
        }
    }
    public function remove($id)
    {
        $file = File::find($id);

        Storage::delete('public'.str_replace(asset('/').'storage', '', $file->src));

        $file->delete();
        
        return response()->json([
            'status' => 'succcess'
        ], 200);
    }
}
