@extends('layouts.app')
@section('title', 'Data Writeoff')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer border-bottom">
            <div class="row mx-1">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length">
                        <button type="button" class="btn btn-outline-primary waves-effect">Data Writeoff</button>

                        @can('Writeoff Update')
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importWriteoff">
                            Import
                        </button>
                        @endcan

                        <a href="#" class="btn btn-success waves-effect waves-light">Export</a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1">
                        <div>
                            <form action="{{ route('writeoff.index') }}" method="GET">
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
                            <td style="width:10%;">Kredit</td>
                            <td>Nama</td>
                            <td>Plafon</td>
                            <td>Wilayah</td>
                            <td>Petugas</td>
                            <td class="text-center" style="width:10%;">Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($writeoff as $index => $item)
                        <tr class="{{ $item->tabelColor }}">
                            <td>{{ $item->nokredit }}</td>
                            <td>{{ $item->nama_debitur }}</td>
                            <td>{{ $item->plafon }}</td>
                            <td>
                                <a href="{{ route('writeoff.index') }}?search={{ $item->wilayah }}" class="text-primary">
                                    {{ $item->wilayah }}
                                </a>
                            </td>
                            <td class="text-uppercase">
                                @if ($item->petugas)
                                <a href="{{ route('writeoff.index') }}?search={{ $item->petugas->name }}" class="text-primary">
                                    {{ $item->petugas->username }}
                                </a>
                                @else
                                <a href="{{ route('writeoff.index') }}?search={{ $item->kode_petugas }}" class="text-danger">
                                    {{ $item->kode_petugas }}
                                </a>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('writeoff.show', $item->nokredit) }}">
                                    <span class="badge badge-center bg-warning w-px-30 h-px-30">
                                        <i class="ti ti-file-text ti-sm"></i>
                                    </span>
                                </a>

                                <a href="{{ route('writeoff.print', $item->nokredit) }}" target="_blank">
                                    <span class="badge badge-center bg-success w-px-30 h-px-30">
                                        <i class="ti ti-printer ti-sm"></i>
                                    </span>
                                </a>
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
                            {{ $writeoff->withQueryString()->onEachSide(0)->links('helper.pagination') }}
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="importWriteoff" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Import Writeoff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('import.writeoff') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">Upload File</label>
                            <a href="{{ asset('import/kredit/importNominatif.xlsx') }}"><small>XLSX Template</small></a>
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