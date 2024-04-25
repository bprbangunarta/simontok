@extends('layouts.app')
@section('title', 'Prospek Kredit')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer border-bottom">
            <div class="row mx-1">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length">
                        <button type="button" class="btn btn-outline-primary waves-effect">Prospek Kredit</button>

                        <a href="{{ route('prospek.create') }}" class="btn btn-primary waves-effect waves-light">Tambah</a>
                        <a href="#" class="btn btn-success waves-effect waves-light">Export</a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1">
                        <div>
                            <form action="{{ route('prospek.index') }}" method="GET">
                                <div class="dataTables_filter">
                                    <label>Pencarian
                                        <input type="search" class="form-control" name="search" value="{{ request('search') }}">
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body" style="margin-top: -20px;">
            <div class="table-responsive text-nowrap mb-3">
                <table class="table" style="font-size: 13px;">
                    <thead class="fw-bold">
                        <tr>
                            <td style="width:10%;">Tanggal</td>
                            <td>Telp</td>
                            <td>Nama</td>
                            <td>Jenis</td>
                            <td>Petugas</td>
                            <td>Status</td>
                            <td class="text-center" style="width:10%;">Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($prospek as $index => $item)
                        <tr>
                            <td>{{ $item->longDate }}</td>
                            <td>{{ $item->nohp }}</td>
                            <td>{{ $item->calon_debitur }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>{{ $item->petugas->name }}</td>
                            <td>
                                <span class="badge badge bg-label-{{ $item->statusColor }}">{{ $item->status }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('prospek.show', $item->id) }}">
                                    <span class="badge badge-center btn-warning w-px-30 h-px-30">
                                        <i class="ti ti-file-text ti-sm"></i>
                                    </span>
                                </a>

                                @can('Prospek Delete')
                                <a href="{{ route('prospek.destroy', $item->id) }}" class="{{ $item->aksesDelete }}" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus prospek ini?')) { document.getElementById('delete-form-{{ $item->id }}').submit(); }">
                                    <span class="badge badge-center bg-danger w-px-30 h-px-30">
                                        <i class="ti ti-trash ti-sm"></i>
                                    </span>
                                </a>

                                <form id="delete-form-{{ $item->id }}" action="{{ route('prospek.destroy', $item->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Data tidak ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="row" style="margin-bottom: -30px;">
                <div class="col-sm-12 col-md-12">
                    <div>
                        <nav aria-label="Page navigation">
                            {{ $prospek->withQueryString()->onEachSide(0)->links('helper.pagination') }}
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('style')
@endpush

@push('script')
@endpush