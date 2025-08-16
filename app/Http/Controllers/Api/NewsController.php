<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsCategoryResource;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsComment;
use App\Models\NewsViewer;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Facades\Agent;
use Stevebauman\Location\Facades\Location;

class NewsController extends Controller
{

    public function index(Request $request)
    {
        try {
            $keyword = $request->input('q');
            $perPage = $request->input('perPage', 10);
            $category = $request->input('category', null);
            $category = $category ? NewsCategory::where('slug', $category)->first() : null;
            $data = News::latest()->where('title', 'like', "%$keyword%")->where('status', 'published')
            ->when($category, fn($query) => $query->where('category_id', $category->id))
            ->paginate($perPage);
            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'News retrieved successfully',
                'meta' => [
                    'query' => $keyword,
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
                'data' => NewsResource::collection($data)
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function show($id)
    {
        try {

            $news_id = $id;
            try {
                $currentUserInfo = Location::get(request()->ip());
                $news_visitor = new NewsViewer();
                $news_visitor->news_id = $news_id;
                $news_visitor->ip = request()->ip();
                if ($currentUserInfo) {
                    $news_visitor->country = $currentUserInfo->countryName;
                    $news_visitor->city = $currentUserInfo->cityName;
                    $news_visitor->region = $currentUserInfo->regionName;
                    $news_visitor->postal_code = $currentUserInfo->postalCode;
                    $news_visitor->latitude = $currentUserInfo->latitude;
                    $news_visitor->longitude = $currentUserInfo->longitude;
                    $news_visitor->timezone = $currentUserInfo->timezone;
                }
                $news_visitor->user_agent = Agent::getUserAgent();
                $news_visitor->platform = Agent::platform();
                $news_visitor->browser = Agent::browser();
                $news_visitor->device = Agent::device();
                $news_visitor->save();
            } catch (\Throwable $th) {
                Log::error('Error saving news viewer: ' . $th->getMessage());
            }

            $data = News::where('id', $id)->get();
            if (!$data) {
                return response()->json([
                    'response' => Response::HTTP_NOT_FOUND,
                    'success' => false,
                    'message' => 'News not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'News show retrieved successfully',
                'data' => NewsResource::collection($data)->first()
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function comment($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required'
        ]);
        $validation = array_fill_keys(array_keys($request->all()), []);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $key => $errors) {
                $validation[$key] = $errors;
            }
            return response()->json([
                'response' => Response::HTTP_BAD_REQUEST,
                'success' => false,
                'message' => 'Validation error occurred',
                'validation' => $validation,
                'data' => null
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $comment = new NewsComment();
            $comment->news_id = $id;
            $comment->name = $request->name;
            $comment->email = $request->email;
            $comment->user_id = $request->user() ? $request->user()->id : null;
            $comment->comment = $request->comment;
            $comment->save();
            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'Comment stored successfully',
                'validation' => $validation,
                'data' => $comment
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function category()
    {
        try {
            $data = NewsCategory::all();
            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'News categories retrieved successfully',
                'data' => NewsCategoryResource::collection($data)
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
