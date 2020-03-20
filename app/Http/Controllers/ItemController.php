<?php

namespace App\Http\Controllers;

use App\Item;
use Validator;
use Illuminate\Http\Request;


class ItemController extends Controller
{
    public function getAll()
    {
        $items = Item::all()->load('categories');;

        return response()-> json([
            'items' => $items
        ], 200);
    }
    public function getOne($id)
    {
        $item = Item::find($id)->load('categories');;

        return response()-> json([
            'item' => $item
        ], 200);
    }
    public function new(Request $request)
    {
        $validateData = json_decode($request->item, true); // преобразуем json в массив(нужно для валидации)

        $validator = Validator::make(
            $validateData,
            [
                'title' => 'required|max:256',
                'description' => 'required|max:2048',
                'cost' => 'required|max:25'
            ],
            $messages = [
                'title.required' => 'Название - обязательное поле',
                'title.max' => 'Название слишком длинное',
                'description.required' => 'Описание - обязательное поле',
                'description.max' => 'Описание слишком длинное',
                'cost.required' => 'Цена - обязательное поле. Введите любое значение. Вы можете отключить ее отображение на сайте',
                'cost.max' => 'Цена слишком большая, наверное...',
            ]
        );
       
        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' =>  json_encode($validator->errors()->all(), JSON_UNESCAPED_UNICODE)
            ], 400);

        } else {

            $categories = json_decode($request->categories);

            $item = json_decode($request->item);

            $item = Item::create([
                'title' => $item->title, 
                'description' => $item->description,
                'cost' => $item->cost
            ]);
            
            if ($categories) {
                foreach ($categories as $category) {
                    $item->categories()->attach($category);
                }
            }

            return response()->json([
                'item' => $item
            ], 200);
        }
        
    }
    public function update(Request $request, $id)
    {
        $validateData = json_decode($request->item, true); // преобразуем json в массив(нужно для валидации)
       
        $validator = Validator::make(
            $validateData,
            [
                'title' => 'required|max:256',
                'description' => 'required|max:2048',
                'cost' => 'required|max:25'
            ],
            $messages = [
                'title.required' => 'Название - обязательное поле',
                'title.max' => 'Название слишком длинное',
                'description.required' => 'Описание - обязательное поле',
                'description.max' => 'Описание слишком длинное',
                'cost.required' => 'Цена - обязательное поле. Введите любое значение. Вы можете отключить ее отображение на сайте',
                'cost.max' => 'Цена слишком большая, наверное...',
            ]
        );
       
        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' =>  json_encode($validator->errors()->all(), JSON_UNESCAPED_UNICODE)
            ], 400);

        } else {

            $categories = json_decode($request->categories);

            $itemNewData = json_decode($request->item);

            $item = Item::find($id);

            $item->title = $itemNewData->title;

            $item->description = $itemNewData->description;

            $item->cost = $itemNewData->cost;
            
            $item->save();

            if (count($item->categories)) {
                foreach ($item->categories as $category) {
                    $toDetach[] = $category->id;
                }
                $item->categories()->detach($toDetach);
            }

            if ($categories) {
                foreach ($categories as $category) {
                    $toAttach[] = $category;
                }
                $item->categories()->attach($toAttach);
            }

            return response()->json([
                'item' => $item
            ], 200);
        }
        
    }
    public function remove($id)
    {
        $item = Item::find($id);

        if (count($item->categories)) {
            foreach ($item->categories as $category) {
                $toDetach[] = $category->id;
            }
            $item->categories()->detach($toDetach);
        }

        $item->delete();

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
