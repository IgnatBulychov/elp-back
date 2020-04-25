<?php

namespace App\Http\Controllers;

use App\Advantage;
use Validator;
use Illuminate\Http\Request;

class AdvantageController extends Controller
{
    public function getAll()
    {
        $advantages = Advantage::all();

        return response()-> json([
            'advantages' => $advantages
        ], 200);
    }
    public function getOne($id)
    {
        $advantage = Advantage::find($id);

        return response()-> json([
            'advantage' => $advantage
        ], 200);
    }
    public function new(Request $request)
    {
        $validateData = json_decode($request->advantage, true); // преобразуем json в массив(нужно для валидации)
       
        $validator = Validator::make(
            $validateData,
            [
                'description' => 'required|max:256',
                'icon' => 'required|max:25'
            ],
            $messages = [
                'description.required' => 'Описание - обязательное поле',
                'description.max' => 'Описание слишком длинное',
                'icon.required' => 'Значек - обязательное поле',
                'icon.max' => 'Поле "значек" слишком длинное'
            ]
        );
       
        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' =>  json_encode($validator->errors()->all(), JSON_UNESCAPED_UNICODE)
            ], 400);

        } else {

            $advantage = json_decode($request->advantage);

            $advantage = Advantage::create([
                'icon' => $advantage->icon,
                'description' => $advantage->description,
            ]);

            return response()->json([
                'advantage' => $advantage
            ], 200);
        }
        
    }
    public function update(Request $request, $id)
    {
        $validateData = json_decode($request->advantage, true); // преобразуем json в массив(нужно для валидации)
       
        $validator = Validator::make(
            $validateData,
            [
                'description' => 'required|max:256',
                'icon' => 'required|max:25'
            ],
            $messages = [
                'description.required' => 'Описание - обязательное поле',
                'description.max' => 'Описание слишком длинное',
                'icon.required' => 'Значек - обязательное поле',
                'icon.max' => 'Поле "значек" слишком длинное'
            ]
        );
       
        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' =>  json_encode($validator->errors()->all(), JSON_UNESCAPED_UNICODE)
            ], 400);

        } else {

            $advantageNewData = json_decode($request->advantage);

            $advantage = Advantage::find($id);

            $advantage->description = $advantageNewData->description;

            $advantage->icon = $advantageNewData->icon;

            $advantage->save();

            return response()->json([
                'advantage' => $advantage
            ], 200);
        }
        
    }
    public function remove($id)
    {
        $advantage = Advantage::find($id);

        $advantage->delete();

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
