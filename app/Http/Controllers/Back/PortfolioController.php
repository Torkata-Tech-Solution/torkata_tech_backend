<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Portfolio',
            'breadcrumbs' => [
                [
                    'name' => 'Portfolio',
                    'link' => route('back.portfolio.index')
                ]
            ],
            'portfolios' => Portfolio::orderBy('order', 'asc')->orderBy('created_at', 'desc')->get()
        ];

        return view('back.pages.portfolio.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Portfolio',
            'breadcrumbs' => [
                [
                    'name' => 'Portfolio',
                    'link' => route('back.portfolio.index')
                ],
                [
                    'name' => 'Tambah Portfolio',
                    'link' => route('back.portfolio.create')
                ]
            ]
        ];

        return view('back.pages.portfolio.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'images' => 'nullable|array|max:10',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'content' => 'nullable|string',
                'client_name' => 'nullable|string|max:255',
                'project_url' => 'nullable|url',
                'github_url' => 'nullable|url',
                'technologies' => 'nullable',
                'project_date' => 'nullable|date',
                'status' => 'required|in:draft,published,archived',
                'order' => 'nullable|integer|min:0',
                'meta_keywords' => 'nullable',
            ],
            [
                'images.max' => 'Maksimal 10 gambar yang dapat diupload',
                'images.*.image' => 'File harus berupa gambar',
                'images.*.mimes' => 'Format file harus jpeg, png, jpg, gif, svg',
                'images.*.max' => 'Ukuran file maksimal 2MB',
                'thumbnail.image' => 'Thumbnail harus berupa gambar',
                'thumbnail.mimes' => 'Format thumbnail harus jpeg, png, jpg, gif, svg',
                'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB',
                'required' => 'Kolom :attribute harus diisi',
                'url' => 'Format URL tidak valid'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', $validator->errors()->all());
        }

        $slug = "";
        if (Portfolio::where('slug', Str::slug($request->title))->count() > 0) {
            $slug = Str::slug($request->title) . '-' . rand(1000, 9999);
        } else {
            $slug = Str::slug($request->title);
        }

        $portfolio = new Portfolio();
        $portfolio->title = $request->title;
        $portfolio->slug = $slug;
        $portfolio->description = $request->description;
        $portfolio->content = $request->content;
        $portfolio->client_name = $request->client_name;
        $portfolio->project_url = $request->project_url;
        $portfolio->github_url = $request->github_url;
        $portfolio->technologies = $request->technologies ? array_column(json_decode($request->technologies), 'value') : null;
        $portfolio->project_date = $request->project_date;
        $portfolio->status = $request->status;
        $portfolio->order = $request->order ?? 0;
        $portfolio->user_id = Auth::user()->id;
        $portfolio->meta_title = $request->title;
        $portfolio->meta_description = Str::limit(strip_tags($request->description), 150);
        $portfolio->meta_keywords = $request->meta_keywords ? implode(", ", array_column(json_decode($request->meta_keywords), 'value')) : null;

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $portfolio->thumbnail = $thumbnail->storeAs('portfolio', date('YmdHis') . '_thumb_' . Str::slug($request->title) . '.' . $thumbnail->getClientOriginalExtension(), 'public');
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $key => $image) {
                $imagePath = $image->storeAs('portfolio', date('YmdHis') . '_img_' . $key . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension(), 'public');
                $images[] = $imagePath;
            }
            $portfolio->images = $images;
        }

        $portfolio->save();

        return redirect()->route('back.portfolio.index')->with('success', 'Portfolio berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Portfolio',
            'breadcrumbs' => [
                [
                    'name' => 'Portfolio',
                    'link' => route('back.portfolio.index')
                ],
                [
                    'name' => 'Edit Portfolio',
                    'link' => route('back.portfolio.edit', $id)
                ]
            ],
            'portfolio' => Portfolio::findOrFail($id)
        ];

        return view('back.pages.portfolio.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'images' => 'nullable|array|max:10',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'content' => 'nullable|string',
                'client_name' => 'nullable|string|max:255',
                'project_url' => 'nullable|url',
                'github_url' => 'nullable|url',
                'technologies' => 'nullable',
                'project_date' => 'nullable|date',
                'status' => 'required|in:draft,published,archived',
                'order' => 'nullable|integer|min:0',
                'meta_keywords' => 'nullable',
            ],
            [
                'images.max' => 'Maksimal 10 gambar yang dapat diupload',
                'images.*.image' => 'File harus berupa gambar',
                'images.*.mimes' => 'Format file harus jpeg, png, jpg, gif, svg',
                'images.*.max' => 'Ukuran file maksimal 2MB',
                'thumbnail.image' => 'Thumbnail harus berupa gambar',
                'thumbnail.mimes' => 'Format thumbnail harus jpeg, png, jpg, gif, svg',
                'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB',
                'required' => 'Kolom :attribute harus diisi',
                'url' => 'Format URL tidak valid'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', $validator->errors()->all());
        }

        $portfolio = Portfolio::findOrFail($id);

        $slug = "";
        if (Portfolio::where('slug', Str::slug($request->title))->where('id', '!=', $id)->count() > 0) {
            $slug = Str::slug($request->title) . '-' . rand(1000, 9999);
        } else {
            $slug = Str::slug($request->title);
        }

        $portfolio->title = $request->title;
        $portfolio->slug = $slug;
        $portfolio->description = $request->description;
        $portfolio->content = $request->content;
        $portfolio->client_name = $request->client_name;
        $portfolio->project_url = $request->project_url;
        $portfolio->github_url = $request->github_url;
        $portfolio->technologies = $request->technologies ? array_column(json_decode($request->technologies), 'value') : null;
        $portfolio->project_date = $request->project_date;
        $portfolio->status = $request->status;
        $portfolio->order = $request->order ?? 0;
        $portfolio->meta_title = $request->title;
        $portfolio->meta_description = Str::limit(strip_tags($request->description), 150);
        $portfolio->meta_keywords = $request->meta_keywords ? implode(", ", array_column(json_decode($request->meta_keywords), 'value')) : null;

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($portfolio->thumbnail && Storage::exists('public/' . $portfolio->thumbnail)) {
                Storage::delete('public/' . $portfolio->thumbnail);
            }

            $thumbnail = $request->file('thumbnail');
            $portfolio->thumbnail = $thumbnail->storeAs('portfolio', date('YmdHis') . '_thumb_' . Str::slug($request->title) . '.' . $thumbnail->getClientOriginalExtension(), 'public');
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            // Delete old images
            if ($portfolio->images) {
                foreach ($portfolio->images as $oldImage) {
                    if (Storage::exists('public/' . $oldImage)) {
                        Storage::delete('public/' . $oldImage);
                    }
                }
            }

            $images = [];
            foreach ($request->file('images') as $key => $image) {
                $imagePath = $image->storeAs('portfolio', date('YmdHis') . '_img_' . $key . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension(), 'public');
                $images[] = $imagePath;
            }
            $portfolio->images = $images;
        }

        $portfolio->save();

        return redirect()->route('back.portfolio.index')->with('success', 'Portfolio berhasil diubah');
    }

    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);

        // Delete thumbnail
        if ($portfolio->thumbnail && Storage::exists('public/' . $portfolio->thumbnail)) {
            Storage::delete('public/' . $portfolio->thumbnail);
        }

        // Delete images
        if ($portfolio->images) {
            foreach ($portfolio->images as $image) {
                if (Storage::exists('public/' . $image)) {
                    Storage::delete('public/' . $image);
                }
            }
        }

        $portfolio->delete();

        return redirect()->back()->with('success', 'Portfolio berhasil dihapus');
    }
}
