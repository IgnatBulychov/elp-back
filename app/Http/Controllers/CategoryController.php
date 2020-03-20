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
    public function getOne($id)
    {
        $category = Category::find($id);

        return response()-> json([
            'category' => $category
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
                'errors' =>  json_encode($validator->errors()->all(), JSON_UNESCAPED_UNICODE)
            ], 400);

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
    public function update(Request $request, $id)
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
                'errors' =>  json_encode($validator->errors()->all(), JSON_UNESCAPED_UNICODE)
            ], 400);

        } else {

            $categoryNewData = json_decode($request->category);


            $category = Category::find($id);

            $category->title = $categoryNewData->title;
            
            $category->save();

            return response()->json([
                'category' => $category
            ], 200);
        }
        
    }
    public function remove($id)
    {
        $category = Category::find($id);

       if (count($category->items)) {
            foreach ($category->items as $item) {
                $toDetach[] = $item->id;
            } 
            $category->items()->detach($toDetach);
        }

        $category->delete();

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
