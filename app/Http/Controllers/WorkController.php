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
        $works = Work::find($id)->load('files');;

        return response()-> json([
            'works' => $works
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

           // $categories = json_decode($request->categories);

            $work = json_decode($request->work);

            $work = Work::create([
                'title' => $work->title, 
                'description' => $work->description
            ]);
            
            /*if ($categories) {
                foreach ($categories as $category) {
                    $item->categories()->attach($category);
                }
            }*/

            return response()->json([
                'work' => $work
            ], 200);
        }
        
    }
}
