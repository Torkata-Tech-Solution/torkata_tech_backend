<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SiteMetaResource;
use App\Models\SettingWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteMetaController extends Controller
{
    public function index()
    {
        try {
            $information = SettingWebsite::first();

            return response()->json([
                'response' => 200,
                'success' => true,
                'message' => 'Meta Site information retrieved successfully',
                'data' => new SiteMetaResource($information)
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
