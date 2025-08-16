<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        try {
            $keyword = $request->input('q', '');
            $perPage = $request->input('perPage', 10);
            $teams = User::inRandomOrder()
                ->where('name', 'like', "%$keyword%")
                ->paginate($perPage);

            return response()->json([
                'response' => 200,
                'success' => true,
                'message' => 'Teams retrieved successfully',
                'meta' => [
                    'query' => $keyword,
                    'path' => $teams->path(),
                    'total' => $teams->total(),
                    'perPage' => $teams->perPage(),
                    'currentPage' => $teams->currentPage(),
                    'lastPage' => $teams->lastPage(),
                    'from' => $teams->firstItem(),
                    'to' => $teams->lastItem(),
                    'hasNext' => $teams->hasMorePages(),
                    'hasPrevious' => $teams->currentPage() > 1,
                ],
                'data' => UserResource::collection($teams)
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
