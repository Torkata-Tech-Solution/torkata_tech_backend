<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioResource;
use App\Models\Portfolio;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        try {
            $keyword = $request->input('q');
            $perPage = $request->input('perPage', 10);
            $technology = $request->input('technology');

            $data = Portfolio::with('user')
                ->where('status', 'published')
                ->when($keyword, function ($query) use ($keyword) {
                    return $query->where(function ($q) use ($keyword) {
                        $q->where('title', 'like', "%$keyword%")
                          ->orWhere('description', 'like', "%$keyword%")
                          ->orWhere('client_name', 'like', "%$keyword%");
                    });
                })
                ->when($technology, function ($query) use ($technology) {
                    return $query->whereJsonContains('technologies', $technology);
                })
                ->orderBy('order', 'asc')
                ->orderBy('project_date', 'desc')
                ->paginate($perPage);

            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'Portfolio retrieved successfully',
                'meta' => [
                    'query' => $keyword,
                    'technology' => $technology,
                    'path' => $data->path(),
                    'total' => $data->total(),
                    'perPage' => $data->perPage(),
                    'currentPage' => $data->currentPage(),
                    'lastPage' => $data->lastPage(),
                    'from' => $data->firstItem(),
                    'to' => $data->lastItem(),
                    'hasNext' => $data->hasMorePages(),
                    'hasPrevious' => $data->currentPage() > 1,
                ],
                'data' => PortfolioResource::collection($data)
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($slug)
    {
        try {
            $data = Portfolio::with('user')->where('slug', $slug)->where('status', 'published')->first();

            if (!$data) {
                return response()->json([
                    'response' => Response::HTTP_NOT_FOUND,
                    'success' => false,
                    'message' => 'Portfolio not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'Portfolio show retrieved successfully',
                'data' => new PortfolioResource($data)
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function featured(Request $request)
    {
        try {
            $limit = $request->input('limit', 6);

            $data = Portfolio::with('user')
                ->where('status', 'published')
                ->orderBy('order', 'asc')
                ->orderBy('project_date', 'desc')
                ->limit($limit)
                ->get();

            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'Featured portfolio retrieved successfully',
                'data' => PortfolioResource::collection($data)
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function technologies()
    {
        try {
            $technologies = Portfolio::where('status', 'published')
                ->whereNotNull('technologies')
                ->pluck('technologies')
                ->flatten()
                ->unique()
                ->values();

            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'Technologies retrieved successfully',
                'data' => $technologies
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
