<?php

namespace App\Http\Controllers;

use App\Category;
use App\Advantage;
use App\Review;
use App\Work;
use App\Settings;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function getAll()
    {
        $categories = Category::all()->load('items');
        $advantages = Advantage::all();
        $reviews = Review::all()->load('files');
        $works = Work::all()->load('files');
        $settings = Settings::all()->first()->load('file');

        return response()-> json([
            'categories' => $categories,
            'advantages' => $advantages,
            'reviews' => $reviews,
            'works' => $works,
            'settings' => $settings
        ], 200);
    }
}
