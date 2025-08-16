<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('perPage', 10);
            $testimonials = Testimonial::latest()->where('status', 1)->paginate($perPage);

            return response()->json([
                'response' => 200,
                'success' => true,
                'message' => 'Testimonials retrieved successfully',
                'meta' => [
                    'path' => $testimonials->path(),
                    'total' => $testimonials->total(),
                    'perPage' => $testimonials->perPage(),
                    'currentPage' => $testimonials->currentPage(),
                    'lastPage' => $testimonials->lastPage(),
                    'from' => $testimonials->firstItem(),
                    'to' => $testimonials->lastItem(),
                    'hasNext' => $testimonials->hasMorePages(),
                    'hasPrevious' => $testimonials->currentPage() > 1,
                ],
                'data' => TestimonialResource::collection($testimonials)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'response' => 500,
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
