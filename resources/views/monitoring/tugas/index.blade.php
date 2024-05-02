@extends('layouts.app')
@section('title', 'Surat Tugas')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer border-bottom">
            <div class="row mx-1">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length">
                        <button type="button" class="btn btn-outline-primary waves-effect">Surat Tugas</button>

                        @can('Tugas Create')
                        <a href="{{ route('tugas.print') }}" class="btn btn-dark waves-effect waves-light" target="_blank">Cetak</a>
                        @endcan

                        @can('Telebilling Create')
                        <a href="{{ route('export.telebilling') }}" class="btn btn-success waves-effect waves-light">Export</a>
                        @endcan
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1">
                        <div>
                            <form action="{{ route('tugas.index') }}" method="GET">
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
                            <td style="width:10%;">Kredit</td>
                            <td>Nama</td>
                            <td>Petugas</td>
                            <td>Jenis</td>
                            <td class="text-center" style="width:10%;">Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tugas as $index => $item)
                        <tr class="{{ $item->tableColor }}">
                            <td>
                                <a href="{{ route('tugas.index') }}?search={{ $item->tanggal }}" class="text-primary">
                                    {{ $item->longDate }}
                                </a>
                            </td>
                            <td>{{ $item->nokredit }}</td>
                            <td>
                                {{ $item->nama_debitur }}
                            </td>
                            <td>
                                <a href="{{ route('tugas.index') }}?search={{ $item->petugas->name }}" class="text-primary">
                                    {{ $item->petugas->name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('tugas.index') }}?search={{ $item->jenis }}" class="text-primary">
                                    {{ $item->jenis }}
                                </a>
                            </td>

                            <td class="text-center">
                                @if ($item->jenis == 'Verifikasi')
                                <a href="{{ route('verifikasi.show', $item->notugas) }}">
                                    <span class="badge badge-center {{ $item->btnColor }} w-px-30 h-px-30">
                                        <i class="ti ti-file-text ti-sm"></i>
                                    </span>
                                </a>
                                @else
                                <a href="{{ route('tugas.show', $item->notugas) }}">
                                    <span class="badge badge-center {{ $item->btnColor }} w-px-30 h-px-30">
                                        <i class="ti ti-file-text ti-sm"></i>
                                    </span>
                                </a>
                                @endif

                                @can('Tugas Delete')
                                @if ($item->btnAccess == 'disabled')
                                <a class="disable-clik">
                                    <span class="badge badge-center bg-danger w-px-30 h-px-30">
                                        <i class="ti ti-trash ti-sm"></i>
                                    </span>
                                </a>
                                @else
                                <a href="{{ route('tugas.destroy', $item->notugas) }}" class="{{ $item->aksesDelete }}" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus tugas ini?')) { document.getElementById('delete-form-{{ $item->notugas }}').submit(); }">
                                    <span class="badge badge-center bg-danger w-px-30 h-px-30">
                                        <i class="ti ti-trash ti-sm"></i>
                                    </span>
                                </a>
                                @endif

                                <form id="delete-form-{{ $item->notugas }}" action="{{ route('tugas.destroy', $item->notugas) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Data tidak ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="row" style="margin-bottom: -30px;">
                <div class="col-sm-12 col-md-12">
                    <div>
                        <nav aria-label="Page navigation">
                            {{ $tugas->withQueryString()->onEachSide(0)->links('helper.pagination') }}
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