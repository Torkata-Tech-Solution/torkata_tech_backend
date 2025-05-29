<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Http\Resources\TestimonialResource;
use App\Http\Resources\UserResource;
use App\Models\News;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $news = News::with(['category', 'user', 'comments', 'viewers'])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $testimonials = Testimonial::where('status', true)->orderBy('created_at', 'desc')->take(5)->get();
        $teams = User::inRandomOrder()->take(5)->get();
        return response()->json([
            'response' => 200,
            'success' => true,
            'message' => 'Home page data retrieved successfully',
            'data' => [
                'news' => NewsResource::collection($news),
                'testimonials' => TestimonialResource::collection($testimonials),
                'teams' => UserResource::collection($teams)
            ]
        ]);
    }
}
