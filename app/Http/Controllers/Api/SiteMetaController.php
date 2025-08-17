<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SettingWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteMetaController extends Controller
{
    public function index()
    {
        try {
            $information = SettingWebsite::first();
            $information->logo = $information->logo ? url(Storage::url($information->logo)) : null;
            $information->favicon = $information->favicon ? url(Storage::url($information->favicon)) : null;

            return response()->json([
                'response' => 200,
                'success' => true,
                'message' => 'Meta Site information retrieved successfully',
                'data' => $information
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
