<?php

namespace App\Http\Controllers;

use App\Review;
use App\File;
use Validator;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function getAll()
    {
        $reviews = Review::all()->load('files');

        return response()-> json([
            'reviews' => $reviews
        ], 200);
    }
    public function getOne($id)
    {
        $review = Review::find($id)->load('files');

        return response()-> json([
            'review' => $review
        ], 200);
    }
    public function new(Request $request)
    {
        $validateData = json_decode($request->review, true); // преобразуем json в массив(нужно для валидации)

        $validator = Validator::make(
            $validateData,
            [
                'name' => 'required|max:128',
                'review' => 'required|max:2048'
            ],
            $messages = [
                'name.required' => 'Имя - обязательное поле',
                'name.max' => 'Имя слишком длинное',
                'review.required' => 'Отзыв - обязательное поле',
                'review.max' => 'Отзыв слишком длинный'
            ]
        );
       
        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' =>  json_encode($validator->errors()->all(), JSON_UNESCAPED_UNICODE)
            ], 400);

        } else {

            $review = json_decode($request->review);

            $files = $review->files;

            $review = Review::create([
                'name' => $review->name, 
                'review' => $review->review
            ]);
            

            if (count($files)) {
                foreach ($files as $file) {
                    $review->files()->attach($file->id);
                }
            }

            return response()->json([
                'review' => $review
            ], 200);
        }    
    }
    public function update(Request $request, $id)
    {
        $validateData = json_decode($request->review, true); // преобразуем json в массив(нужно для валидации)

        $validator = Validator::make(
            $validateData,
            [
                'name' => 'required|max:128',
                'review' => 'required|max:2048'
            ],
            $messages = [
                'name.required' => 'Имя - обязательное поле',
                'name.max' => 'Имя слишком длинное',
                'review.required' => 'Отзыв - обязательное поле',
                'review.max' => 'Отзыв слишком длинный'
            ]
        );
       
        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' =>  json_encode($validator->errors()->all(), JSON_UNESCAPED_UNICODE)
            ], 400);

        } else {

            $newReview = json_decode($request->review);

            $newFiles = $newReview->files;
            
            $review = Review::find($id);

            $oldFiles = $review->files;

            $review->name = $newReview->name;

            $review->review = $newReview->review;
            
            $review->save();

            if (count($oldFiles)) {
                foreach ($oldFiles as $file) {
                    $toDetach[] = $file->id;
                }
                $review->files()->detach($toDetach);
            }

            if (count($newFiles)) {
                foreach ($newFiles as $file) {
                    $review->files()->attach($file->id);
                }
            }

            return response()->json([
                'review' =>  $review
            ], 200);
        }
        
    }
    public function remove($id)
    {
        $review = Review::find($id);

        if (count($review->files)) {
            foreach ($review->files as $file) {
                $toDetach[] = $file->id;
            }
            $review->files()->detach($toDetach);
        }

        $review->delete();

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
