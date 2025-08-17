@extends('back.app')
@section('content')
    <div id="kt_content_container" class=" container-xxl ">
        <div class="card card-flush">
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" data-kt-ecommerce-product-filter="search"
                            class="form-control form-control-solid w-250px ps-12" placeholder="Cari Portfolio" />
                    </div>
                </div>
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <div class="w-100 mw-150px">
                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                            data-placeholder="Status" data-kt-ecommerce-product-filter="status">
                            <option></option>
                            <option value="all">Semua</option>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                    <a href="{{ route('back.portfolio.create') }}" class="btn btn-primary">
                        <i class="ki-duotone ki-plus fs-2"></i>Tambah Portfolio</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                        data-kt-check-target="#kt_ecommerce_products_table .form-check-input"
                                        value="1" />
                                </div>
                            </th>
                            <th class="min-w-200px">Portfolio</th>
                            <th class="text-end min-w-100px">Client</th>
                            <th class="text-end min-w-100px">Technologies</th>
                            <th class="text-end min-w-100px">Order</th>
                            <th class="text-end min-w-100px">Status</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach ($portfolios as $portfolio)
                            <tr>
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="symbol symbol-50px">
                                            <span class="symbol-label"
                                                style="background-image:url( @if ($portfolio->thumbnail) {{ Storage::url($portfolio->thumbnail) }} @else {{ asset('back/media/svg/files/blank-image.svg') }} @endif);"></span>
                                        </a>
                                        <div class="ms-5">
                                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1"
                                                data-kt-ecommerce-category-filter="category_name">{{ $portfolio->title }}</a>
                                            <div class="text-muted fs-7 fw-bold">
                                                {{ Str::limit(strip_tags($portfolio->description), 80) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end pe-0">
                                    <span class="fw-bold">{{ $portfolio->client_name ?? '-' }}</span>
                                </td>
                                <td class="text-end pe-0">
                                    <div class="d-flex flex-wrap justify-content-end">
                                        @if($portfolio->technologies)
                                            @foreach(array_slice($portfolio->technologies, 0, 2) as $tech)
                                                <span class="badge badge-light-primary me-1 mb-1">{{ $tech }}</span>
                                            @endforeach
                                            @if(count($portfolio->technologies) > 2)
                                                <span class="badge badge-light-secondary">+{{ count($portfolio->technologies) - 2 }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-end pe-0">
                                    <span class="fw-bold">{{ $portfolio->order }}</span>
                                </td>
                                <td class="text-end pe-0">
                                    @if ($portfolio->status == 'published')
                                        <div class="badge badge-light-success">Published</div>
                                    @elseif ($portfolio->status == 'draft')
                                        <div class="badge badge-light-primary">Draft</div>
                                    @else
                                        <div class="badge badge-light-danger">Archived</div>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="#"
                                        class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a href="{{ route('back.portfolio.edit', $portfolio->id) }}"
                                                class="menu-link px-3">Edit</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#delete_portfolio{{ $portfolio->id }}">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @foreach ($portfolios as $portfolio)
        <div class="modal fade" tabindex="-1" id="delete_portfolio{{ $portfolio->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Hapus Portfolio</h3>
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <form action="{{ route('back.portfolio.destroy', $portfolio->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <p>Apakah Anda yakin ingin menghapus Portfolio <strong>{{ $portfolio->title }}</strong>?</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@section('scripts')
    <script src="{{ asset('back/js/custom/apps/ecommerce/catalog/news.js') }}"></script>
@endsection
