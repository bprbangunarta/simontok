@extends('layouts.app')
@section('title', 'Verifikasi Debitur')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div class="dataTables_wrapper dt-bootstrap5 no-footer border-bottom">
            <div class="row mx-1">
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                    <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3">
                        @can('Tugas Create')
                        <div class="dt-buttons btn-group flex-wrap">
                            <a href="{{ route('tugas.print') }}" class="btn btn-secondary btn-primary waves-effect waves-light" target="_blank">
                                <i class="ti ti-printer me-md-1"></i> Cetak
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>

                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3">
                    <div class="dataTables_filter">
                        <form action="{{ route('verifikasi.index') }}" method="GET">
                            <label>
                                <input type="search" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search">
                            </label>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body" style="margin-top: -20px;">
            <div class="table-responsive text-nowrap mb-3">
                <table class="table" id="datatable">
                    <thead class="fw-bold">
                        <tr>
                            <td style="width:10%;">Tanggal</td>
                            <td>Debitur</td>
                            <td>NoKredit</td>
                            <td>Petugas</td>
                            <td class="text-center" style="width:10%;">Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($verifikasi as $index => $item)
                        <tr class="{{ $item->tableColor }}">
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->kredit->nama_debitur }}</td>
                            <td>{{ $item->nokredit }}</td>
                            <td>{{ $item->petugas->name }}</td>

                            <td class="text-center">
                                <a href="{{ route('verifikasi.show', $item->notugas) }}">
                                    <span class="badge badge-center {{ $item->btnColor }} w-px-30 h-px-30">
                                        <i class="ti ti-file-text ti-sm"></i>
                                    </span>
                                </a>

                                @can('Tugas Delete')
                                @if ($item->btnAccess == 'disabled')
                                <a class="disable-clik">
                                    <span class="badge badge-center bg-danger w-px-30 h-px-30">
                                        <i class="ti ti-trash ti-sm"></i>
                                    </span>
                                </a>
                                @else
                                <a href="{{ route('verifikasi.destroy', $item->notugas) }}" class="{{ $item->aksesDelete }}" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus tugas ini?')) { document.getElementById('delete-form-{{ $item->notugas }}').submit(); }" disable>
                                    <span class="badge badge-center bg-danger w-px-30 h-px-30">
                                        <i class="ti ti-trash ti-sm"></i>
                                    </span>
                                </a>
                                @endif

                                <form id="delete-form-{{ $item->notugas }}" action="{{ route('verifikasi.destroy', $item->notugas) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Data tidak ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="row" style="margin-bottom: -30px;">
                <div class="col-sm-12 col-md-12">
                    <div>
                        <nav aria-label="Page navigation">
                            {{ $verifikasi->withQueryString()->onEachSide(0)->links('helper.pagination') }}
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