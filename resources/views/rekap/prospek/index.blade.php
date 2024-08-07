@extends('layouts.app')
@section('title', 'Rekap Prospek')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer border-bottom">
            <div class="row mx-1">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length">
                        <button type="button" class="btn btn-success">Export</button>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1">
                        <div>
                            <form action="{{ route('rekap.wilayah') }}" method="GET">
                                <div class="dataTables_filter">
                                    <input type="date" class="form-control" name="search" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-icon btn-label-github waves-effect">
                                        <i class="tf-icons ti ti-filter"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body" style="margin-top: -20px;">
            <div class="table-responsive text-nowrap mb-3">
                <table class="table" id="dataRekap" style="font-size: 13px;">
                    <thead class="fw-bold">
                        <tr>
                            <th>Wilayah</th>
                            <th class="text-center">Tahun</th>
                            <th class="text-center">Bulan</th>
                            <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Total Tugas">TTL</th>
                            <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Total Tugas Dikerjakan">TTD</th>
                            <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Total Tugas Tidak Dikerjakan">TTT</th>
                            <th class="text-center">Rasio</th>
                            <th class="text-center">Performa</th>
                            <th class="text-center" style="width:10%;">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection