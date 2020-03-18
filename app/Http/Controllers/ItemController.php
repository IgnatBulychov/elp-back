<?php

namespace App\Http\Controllers;

use App\Item;
use Validator;
use Illuminate\Http\Request;


class ItemController extends Controller
{
    public function getAll()
    {
        $items = Item::all();

        return response()-> json([
            'items' => $items
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

            // $category = App\Category::find($categoryID);

            $category = $request->category;

            $item = json_decode($request->item);

            $item = Item::create([
                'title' => $item->title, 
                'description' => $item->description,
                'cost' => $item->cost
            ]);

            $item->categories()->attach($category);

            return response()->json([
                'item' => $item
            ], 200);
        }
        
    }
}
