@extends('layouts.app')
@section('title', 'Data Agunan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer border-bottom">
            <div class="row mx-1">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length">
                        <button type="button" class="btn btn-outline-primary waves-effect">Data Agunan</button>

                        @can('Agunan Update')
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importAgunan">
                            Import
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1">
                        <div>
                            <form action="{{ route('agunan.index') }}" method="GET">
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
                            <td>Kredit</td>
                            <td>Nama</td>
                            <td>Agunan</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($agunan as $index => $item)
                        <tr>
                            <td>{{ $item->nokredit }}</td>
                            <td>{{ $item->kredit->nama_debitur }}</td>
                            <td>{{ $item->agunan }}</td>
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
                            {{ $agunan->withQueryString()->onEachSide(0)->links('helper.pagination') }}
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="importKredit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Import Kredit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('import.kredit') }}" method="POST" enctype="multipart/form-data">
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

<!-- Modal -->
<div class="modal fade" id="importAgunan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Import Agunan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('import.agunan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">Upload File</label>
                            <a href="{{ asset('import/agunan/importAgunan.xlsx') }}"><small>XLSX Template</small></a>
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