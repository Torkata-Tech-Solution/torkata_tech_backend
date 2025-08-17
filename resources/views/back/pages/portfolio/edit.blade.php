@extends('back.app')
@section('content')
    <div id="kt_content_container" class=" container-xxl ">
        <form id="kt_portfolio_edit_form" class="form d-flex flex-column flex-lg-row"
            action="{{ route('back.portfolio.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                <!--begin::Thumbnail settings-->
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Thumbnail</h2>
                        </div>
                    </div>
                    <div class="card-body text-center pt-0">
                        <style>
                            .image-input-placeholder {
                                background-image: url('{{ asset('back/media/svg/files/blank-image.svg') }}');
                            }

                            [data-bs-theme="dark"] .image-input-placeholder {
                                background-image: url('{{ asset('back/media/svg/files/blank-image-dark.svg') }}');
                            }
                        </style>
                        <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                            data-kt-image-input="true"
                            @if($portfolio->thumbnail)
                                style="background-image: url('{{ $portfolio->getThumbnail() }}')"
                            @endif>
                            <div class="image-input-wrapper w-150px h-150px"
                                @if($portfolio->thumbnail)
                                    style="background-image: url('{{ $portfolio->getThumbnail() }}')"
                                @endif></div>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ubah Thumbnail">
                                <i class="ki-duotone ki-pencil fs-7">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="file" name="thumbnail" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batalkan Thumbnail">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Hapus Thumbnail">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                        </div>
                        <div class="text-muted fs-7">
                            Set Thumbnail Portfolio, hanya menerima file dengan ekstensi .png, .jpg, .jpeg
                        </div>
                    </div>
                </div>
                <!--end::Thumbnail settings-->

                <!--begin::Current Images-->
                @if($portfolio->images && count($portfolio->images) > 0)
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Gambar Saat Ini</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            @foreach($portfolio->getImages() as $image)
                                <div class="col-6 mb-3">
                                    <div class="image-input-wrapper w-100 h-100px"
                                        style="background-image: url('{{ $image }}'); background-size: cover; background-position: center;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-muted fs-7">
                            Upload gambar baru akan mengganti semua gambar yang ada
                        </div>
                    </div>
                </div>
                @endif
                <!--end::Current Images-->

                <!--begin::Multiple Images-->
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Galeri Gambar Baru</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <input type="file" name="images[]" class="form-control" multiple accept=".png,.jpg,.jpeg" id="images_input" />
                        @error('images')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror
                        <div class="text-muted fs-7 mt-3">
                            Upload gambar baru untuk mengganti galeri yang ada. Maksimal 10 file dengan ekstensi .png, .jpg, .jpeg
                        </div>
                        <div id="selected_images_preview" class="mt-3" style="display: none;">
                            <h6>File yang dipilih:</h6>
                            <ul id="selected_files_list" class="list-group"></ul>
                        </div>
                    </div>
                </div>
                <!--end::Multiple Images-->

                <!--begin::Status-->
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Status</h2>
                        </div>
                        <div class="card-toolbar">
                            <div class="rounded-circle bg-success w-15px h-15px" id="kt_portfolio_edit_status">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <select name="status" class="form-select mb-2" data-control="select2" data-hide-search="true"
                            data-placeholder="Select an option" id="kt_portfolio_edit_status_select" required>
                            <option></option>
                            <option value="published" {{ old('status', $portfolio->status) == 'published' ? 'selected' : '' }}>Published
                            </option>
                            <option value="draft" {{ old('status', $portfolio->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archived" {{ old('status', $portfolio->status) == 'archived' ? 'selected' : '' }}>Archived
                            </option>
                        </select>
                        @error('status')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror
                        <div class="text-muted fs-7">
                            Set Status Portfolio, <code>Published</code> untuk mempublikasikan portfolio, <code>Draft</code>
                            untuk menyimpan portfolio sebagai draft, <code>Archived</code> untuk menyimpan portfolio sebagai
                            arsip
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Urutan Tampil (Order)</label>
                            <input type="number" name="order" class="form-control" placeholder="0"
                                value="{{ old('order', $portfolio->order) }}" min="0" />
                            @error('order')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                            <div class="text-muted fs-7">
                                Angka yang lebih kecil akan ditampilkan lebih dahulu
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Status-->
            </div>
            <!--end::Aside column-->

            <!--begin::Main column-->
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <!--begin::General options-->
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Portfolio Details</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-10 fv-row">
                            <label class="required form-label">Judul Portfolio</label>
                            <input type="text" name="title" class="form-control mb-2" placeholder="Judul Portfolio"
                                value="{{ old('title', $portfolio->title) }}" required />
                            @error('title')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10 fv-row">
                            <label class="required form-label">Deskripsi Singkat</label>
                            <textarea name="description" class="form-control mb-2" rows="3" placeholder="Deskripsi singkat portfolio" required>{{ old('description', $portfolio->description) }}</textarea>
                            @error('description')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-10">
                            <div class="col-md-6">
                                <label class="form-label">Nama Client</label>
                                <input type="text" name="client_name" class="form-control mb-2" placeholder="Nama Client"
                                    value="{{ old('client_name', $portfolio->client_name) }}" />
                                @error('client_name')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Project</label>
                                <input type="date" name="project_date" class="form-control mb-2"
                                    value="{{ old('project_date', $portfolio->project_date?->format('Y-m-d')) }}" />
                                @error('project_date')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-10">
                            <div class="col-md-6">
                                <label class="form-label">Project URL</label>
                                <input type="url" name="project_url" class="form-control mb-2" placeholder="https://example.com"
                                    value="{{ old('project_url', $portfolio->project_url) }}" />
                                @error('project_url')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">GitHub URL</label>
                                <input type="url" name="github_url" class="form-control mb-2" placeholder="https://github.com/username/repo"
                                    value="{{ old('github_url', $portfolio->github_url) }}" />
                                @error('github_url')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Technologies Used</label>
                            <input id="technology_tagify" name="technologies" class="form-control mb-2"
                                value="{{ old('technologies', $portfolio->technologies ? json_encode(array_map(fn($tech) => ['value' => $tech], $portfolio->technologies)) : '') }}" />
                            @error('technologies')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                            <div class="text-muted fs-7">
                                Tambahkan teknologi yang digunakan, pisahkan dengan koma <code>,</code> jika lebih dari satu teknologi
                            </div>
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Content Detail</label>
                            <div id="quill_content" name="kt_portfolio_edit_description" class="min-h-400px mb-2">
                                {!! old('content', $portfolio->content) !!}
                            </div>
                            <input type="hidden" name="content" id="content">
                            @error('content')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label">Meta Tag Keywords</label>
                            <input id="keyword_tagify" name="meta_keywords" class="form-control mb-2"
                                value="{{ old('meta_keywords', $portfolio->meta_keywords) }}" />
                            @error('meta_keywords')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                            <div class="text-muted fs-7">
                                Meta Tag Keywords digunakan untuk SEO, pisahkan dengan koma <code>,</code> jika lebih
                                dari satu keyword yang digunakan
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::General options-->

                <div class="d-flex justify-content-end">
                    <a href="{{ route('back.portfolio.index') }}" id="kt_portfolio_edit_cancel"
                        class="btn btn-light me-5">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Update Portfolio</span>
                    </button>
                </div>
            </div>
            <!--end::Main column-->
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        // Quill Editor
        var quill = new Quill('#quill_content', {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'], // toggled buttons
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video', 'formula'],
                    [{
                        header: [1, 2, 3, 4, 5, 6, false]
                    }], // custom button values
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }, {
                        'list': 'check'
                    }],
                    [{
                        'script': 'sub'
                    }, {
                        'script': 'super'
                    }], // superscript/subscript
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }], // outdent/indent
                    [{
                        'direction': 'rtl'
                    }], // text direction
                    [{
                        'color': []
                    }, {
                        'background': []
                    }], // dropdown with defaults from theme
                    [{
                        'font': []
                    }],
                    [{
                        'align': []
                    }],
                    ['clean'] // remove formatting button
                ]
            },
            placeholder: 'Tulis detail portfolio disini...',
            theme: 'snow' // or 'bubble'
        });

        $("#content").val(quill.root.innerHTML);
        quill.on('text-change', function() {
            $("#content").val(quill.root.innerHTML);
        });

        // Technology Tagify
        var technologyTagify = new Tagify(document.querySelector("#technology_tagify"), {
            whitelist: ['Laravel', 'PHP', 'Vue.js', 'React', 'Angular', 'Node.js', 'JavaScript', 'TypeScript', 'MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'Docker', 'AWS', 'Bootstrap', 'Tailwind CSS', 'jQuery', 'Git', 'Firebase', 'Stripe', 'PayPal'],
            dropdown: {
                maxItems: 20,
                classname: "tags-look",
                enabled: 0,
                closeOnSelect: true
            }
        });

        // Keywords Tagify
        var keywordTagify = new Tagify(document.querySelector("#keyword_tagify"), {
            whitelist: [],
            dropdown: {
                maxItems: 20,
                classname: "tags-look",
                enabled: 0,
                closeOnSelect: true
            }
        });

        // Handle multiple images preview
        document.getElementById('images_input').addEventListener('change', function(e) {
            const files = e.target.files;
            const previewDiv = document.getElementById('selected_images_preview');
            const filesList = document.getElementById('selected_files_list');

            if (files.length > 0) {
                previewDiv.style.display = 'block';
                filesList.innerHTML = '';

                if (files.length > 10) {
                    alert('Maksimal 10 file yang dapat diupload');
                    e.target.value = '';
                    previewDiv.style.display = 'none';
                    return;
                }

                Array.from(files).forEach(function(file, index) {
                    const listItem = document.createElement('li');
                    listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                    listItem.innerHTML = `
                        <span>${file.name}</span>
                        <span class="badge badge-secondary">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
                    `;
                    filesList.appendChild(listItem);
                });
            } else {
                previewDiv.style.display = 'none';
            }
        });
    </script>
@endsection
