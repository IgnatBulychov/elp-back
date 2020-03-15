<?php

namespace App\Http\Controllers;

use App\Category;
use Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAll()
    {
        $categories = Category::all();

        return response()-> json([
            'categories' => $categories
        ], 200);
    }
    public function new(Request $request)
    {
        $validateData = json_decode($request->category, true); // преобразуем json в массив(нужно для валидации)
       
        $validator = Validator::make(
            $validateData,
            [
                'title' => 'required|max:256'
            ],
            $messages = [
                'title.required' => 'Название - обязательное поле',
                'title.max' => 'Название слишком длинное'
            ]
        );
       
        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' =>  $validator->errors()->all()
            ]);

        } else {

            // $category = App\Category::find($categoryID);

            $category = json_decode($request->category);

            $category = Category::create([
                'title' => $category->title
            ]);

           // $item->categories()->attach($categoryID);

            return response()->json([
                'category' => $category
            ], 200);
        }
        
    }
}
