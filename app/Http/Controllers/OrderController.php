<?php

namespace App\Http\Controllers;

use App\Order;
use Validator;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getAll()
    {
        $orders = Order::all();

        return response()-> json([
            'orders' => $orders
        ], 200);
    }
    public function new(Request $request)
    {
        $validateData = json_decode($request->order, true); // преобразуем json в массив(нужно для валидации)
       
        $validator = Validator::make(
            $validateData,
            [
                'name' => 'required|max:128',
                'phone' => 'max:25',
                'email' => 'max:50',
                'description' => 'required|max:2048',
            ],
            $messages = [
                'name.required' => 'Имя - обязательное поле',
                'name.max' => 'Имя слишком длинное',
                'phone.max' => 'Телефон слишком длиный',
                'email.max' => 'Email слишком длинный',
                'description.required' => 'Описание заявки - обязательное поле',
                'description.max' => 'Описание заявки слишком длинное',
            ]
        );
       
        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' =>  json_encode($validator->errors()->all(), JSON_UNESCAPED_UNICODE)
            ], 400);

        } else {

            $order = json_decode($request->order);

            $order = Order::create([
                'name' => $order->name,
                'phone' => $order->phone,
                'email' => $order->email,
                'description' => $order->description,
            ]);

            return response()->json([
                'order' => $order
            ], 200);
        }
        
    }
    public function remove($id)
    {
        $order = Order::find($id);

        $order->delete();

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
