<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Partner;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('perPage', 10);

            $clients = Partner::latest()->paginate($perPage);

            return response()->json([
                'response' => 200,
                'success' => true,
                'message' => 'Clients retrieved successfully',
                'meta' => [
                    'path' => $clients->path(),
                    'total' => $clients->total(),
                    'perPage' => $clients->perPage(),
                    'currentPage' => $clients->currentPage(),
                    'lastPage' => $clients->lastPage(),
                    'from' => $clients->firstItem(),
                    'to' => $clients->lastItem(),
                    'hasNext' => $clients->hasMorePages(),
                    'hasPrevious' => $clients->currentPage() > 1,
                ],
                'data' => ClientResource::collection($clients)
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
