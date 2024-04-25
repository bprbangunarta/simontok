@extends('layouts.app')
@section('title', 'Kelola Users')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer border-bottom">
            <div class="row mx-1">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length">
                        <button type="button" class="btn btn-outline-primary waves-effect">Data User</button>
                        <a href="{{ route('user.create') }}" class="btn btn-primary waves-effect waves-light">Tambah</a>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                            Import
                        </button>

                        <a href="{{ route('export.user') }}" class="btn btn-success waves-effect waves-light">Export</a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1">
                        <div>
                            <form action="{{ route('user.index') }}" method="GET">
                                <div class="dataTables_filter">
                                    <label>Search
                                        <input type="search" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search..">
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body" style="margin-top: -20px;">
            <div class="table-responsive text-nowrap mb-3" style="border-bottom: 1px solid #DBDADE;">
                <table class="table" id="datatable">
                    <thead class="fw-bold">
                        <tr>
                            <td>Name</td>
                            <td>Username</td>
                            <td>Email</td>
                            <td>Role</td>
                            <td class="text-center" style="width:10%;">Action</td>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($users as $index => $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <a href="{{ route('user.index') }}/?search={{ $item->roles->pluck('name')[0] ?? '' }}">
                                    <span class="badge {{ $item->status }}">
                                        {{ $item->roles->pluck('name')[0] ?? '' }}</span>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('access.user', $item->id) }}">
                                    <span class="badge badge-center bg-success w-px-30 h-px-30">
                                        <i class="ti ti-lock-check ti-sm"></i>
                                    </span>
                                </a>

                                <a href="{{ route('user.edit', $item->id) }}">
                                    <span class="badge badge-center bg-warning w-px-30 h-px-30">
                                        <i class="ti ti-user-edit ti-sm"></i>
                                    </span>
                                </a>

                                <a href="{{ route('user.destroy', $item->id) }}" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) { document.getElementById('delete-form-{{ $item->id }}').submit(); }">
                                    <span class="badge badge-center bg-danger w-px-30 h-px-30">
                                        <i class="ti ti-trash ti-sm"></i>
                                    </span>
                                </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('user.destroy', $item->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="10">Tidak ditemukan data yang cocok</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="row" style="margin-bottom: -30px;">
                <div class="col-sm-12 col-md-12">
                    <div>
                        <nav aria-label="Page navigation">
                            {{ $users->withQueryString()->onEachSide(0)->links('helper.pagination') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Import Users</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('import.user') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">Upload File</label>
                            <a href="{{ asset('import/users/!SAMPLE.xlsx') }}"><small>XLSX Template</small></a>
                        </div>
                        <div class="col">
                            <input type="file" class="form-control" name="file" accept=".xlsx" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('style')
@endpush

@push('script')
@endpush