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
        // Ambil 1 news terbaru sebagai "news_utama"
        $news_utama = News::with(['category', 'user', 'comments', 'viewers'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->first();

        // Ambil 4 news berikutnya sebagai "news_lainnya"
        $news_lainnya = News::with(['category', 'user', 'comments', 'viewers'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->skip(1)
            ->take(3)
            ->get();
        $testimonials = Testimonial::where('status', true)->orderBy('created_at', 'desc')->take(9)->get();
        $teams = User::inRandomOrder()->take(10)->get();
        return response()->json([
            'response' => 200,
            'success' => true,
            'message' => 'Home page data retrieved successfully',
            'data' => [
                'first_news' => NewsResource::make($news_utama),
                'other_news' => NewsResource::collection($news_lainnya),
                'testimonials' => [
                    'group_1' => TestimonialResource::collection($testimonials->slice(0, 3)),
                    'group_2' => TestimonialResource::collection($testimonials->slice(3, 3)),
                    'group_3' => TestimonialResource::collection($testimonials->slice(6, 3)),
                ],
                'teams' => UserResource::collection($teams)
            ]
        ]);
    }
}
