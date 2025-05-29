<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use App\Models\SettingWebsite;
use Illuminate\Http\Request;

class InformationController extends Controller
{
     public function index(Request $request)
    {
        $information = SettingWebsite::first();
        $category_news =  NewsCategory::all();
        return response()->json([
            'response' => 200,
            'success' => true,
            'message' => 'information data retrieved successfully',
            'data' => [
                'information' => $information,
                'news_categories' => $category_news
            ]
        ]);
    }
}
