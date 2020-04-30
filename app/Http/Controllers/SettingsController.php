<?php

namespace App\Http\Controllers;

use App\Files;
use App\Settings;
use Validator;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getAll()
    {
        $settings = Settings::all()->first()->load('file');

        return response()-> json([
            'settings' => $settings
        ], 200);
    }
    public function update(Request $request)
    {
        $validateData = json_decode($request->settings, true); // преобразуем json в массив(нужно для валидации)
       
        $validator = Validator::make(
            $validateData,
            [
                'title' => 'max:64',
                'description' => 'max:2048',
                'about' => 'max:4048',
                'phone' => 'max:20',
                'email' => 'max:128',
                'viber' => 'max:20',
                'telegram' => 'max:20',
                'whatsapp' => 'max:20',
                'facebook' => 'max:128',
                'instagram' => 'max:128',
                'map' => 'max:4048',
            ],
            $messages = [
                'title.max' => 'Заголовок слишком длинный',
                'description.max' => 'Подзаголовок слишком длинный',
                'about.max' => 'Текст слишком длинный',
                'phone.max' => 'Номер телефона слишком длинный',
                'email.max' => 'E-mail слишком длинный',
                'viber.max' => 'Номер Viber слишком длинный',
                'telegram.max' => 'Номер Telegram слишком длинный',
                'whatsapp.max' => 'Номер WhatsApp слишком длинный',
                'facebook.max' => 'Адрес facebook слишком длинный',
                'instagram.max' => 'Адрес Instagram слишком длинный',
                'map.max' => 'Скрипт карты слишком длинный',
            ]
        );
       
        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' =>  json_encode($validator->errors()->all(), JSON_UNESCAPED_UNICODE)
            ], 400);

        } else {

            $settingsNewData = json_decode($request->settings);

            $settings = Settings::all()->first();

            $settings->title = $settingsNewData->title;
            $settings->subtitle = $settingsNewData->subtitle;
            $settings->file_id = $settingsNewData->file_id;
            $settings->about = $settingsNewData->about;
            $settings->phone = $settingsNewData->phone;
            $settings->email = $settingsNewData->email;
            $settings->viber = $settingsNewData->viber;
            $settings->telegram = $settingsNewData->telegram;
            $settings->whatsapp = $settingsNewData->whatsapp;
            $settings->facebook = $settingsNewData->facebook;
            $settings->instagram = $settingsNewData->instagram;
            $settings->map = $settingsNewData->map;
            
            $settings->save();

            return response()->json([
                'settings' => $settings,
                'file' => $settings->file
            ], 200);
        }
        
    }
}
