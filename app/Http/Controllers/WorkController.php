<?php

namespace App\Http\Controllers;

use App\Work;
use App\File;
use Validator;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function getAll()
    {
        $works = Work::all()->load('files');

        return response()-> json([
            'works' => $works
        ], 200);
    }
    public function getOne($id)
    {
        $work = Work::find($id)->load('files');

        return response()-> json([
            'work' => $work
        ], 200);
    }
    public function new(Request $request)
    {
        $validateData = json_decode($request->work, true); // преобразуем json в массив(нужно для валидации)

        $validator = Validator::make(
            $validateData,
            [
                'title' => 'required|max:256',
                'description' => 'required|max:2048'
            ],
            $messages = [
                'title.required' => 'Название - обязательное поле',
                'title.max' => 'Название слишком длинное',
                'description.required' => 'Описание - обязательное поле',
                'description.max' => 'Описание слишком длинное'
            ]
        );
       
        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' =>  json_encode($validator->errors()->all(), JSON_UNESCAPED_UNICODE)
            ], 400);

        } else {

            $work = json_decode($request->work);

            $files = $work->files;

            $work = Work::create([
                'title' => $work->title, 
                'description' => $work->description
            ]);
            

            if (count($files)) {
                foreach ($files as $file) {
                    $work->files()->attach($file->id);
                }
            }

            return response()->json([
                'work' => $work
            ], 200);
        }    
    }
    public function update(Request $request, $id)
    {
        $validateData = json_decode($request->work, true); // преобразуем json в массив(нужно для валидации)

        $validator = Validator::make(
            $validateData,
            [
                'title' => 'required|max:256',
                'description' => 'required|max:2048'
            ],
            $messages = [
                'title.required' => 'Название - обязательное поле',
                'title.max' => 'Название слишком длинное',
                'description.required' => 'Описание - обязательное поле',
                'description.max' => 'Описание слишком длинное'
            ]
        );
       
        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' =>  json_encode($validator->errors()->all(), JSON_UNESCAPED_UNICODE)
            ], 400);

        } else {

            $newWork = json_decode($request->work);

            $newFiles = $newWork->files;
            
            $work = Work::find($id);

            $oldFiles = $work->files;

            $work->title = $newWork->title;

            $work->description = $newWork->description;
            
            $work->save();

            if (count($oldFiles)) {
                foreach ($oldFiles as $file) {
                    $toDetach[] = $file->id;
                }
                $work->files()->detach($toDetach);
            }

            if (count($newFiles)) {
                foreach ($newFiles as $file) {
                    $work->files()->attach($file->id);
                }
            }

            return response()->json([
                'work' =>  $work
            ], 200);
        }
        
    }
    public function remove($id)
    {
        $work = Work::find($id);

        if (count($work->files)) {
            foreach ($work->files as $file) {
                $toDetach[] = $file->id;
            }
            $work->files()->detach($toDetach);
        }

        $work->delete();

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
