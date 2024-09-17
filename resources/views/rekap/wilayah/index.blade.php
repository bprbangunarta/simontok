@extends('layouts.app')
@section('title', 'Rekap Penanganan Wilayah')

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
                    <tbody>
                        @forelse ($rekap as $index => $item)
                        <tr>
                            <td>{{ $item->wilayah }}</td>
                            <td class="text-center">{{ $item->tahun }}</td>
                            <td class="text-center">{{ $item->bulan }}</td>
                            <td class="text-center">{{ $item->tugas }}</td>
                            <td class="text-center">{{ $item->dikerjakan }}</td>
                            <td class="text-center">{{ $item->tidak_dikerjakan }}</td>
                            <td class="text-center">{{ $item->persentase }}</td>
                            <td class="text-center">
                                @if ($item->persentase > 80)
                                <span class="badge bg-success">Baik</span>
                                @elseif ($item->persentase > 60)
                                <span class="badge bg-warning">Cukup</span>
                                @elseif ($item->persentase > 40)
                                <span class="badge bg-danger">Buruk</span>
                                @else
                                <span class="badge bg-danger">Sangat Buruk</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('rekap.wilayah.show') }}" class="btn btn-sm btn-primary" target="_blank" onclick="event.preventDefault(); document.getElementById('show-form-{{ $item->wilayah }}').submit();">Detail</a>
                            </td>

                            <form id="show-form-{{ $item->wilayah }}" action="{{ route('rekap.wilayah.show') }}" method="POST" target="_blank" style="display: none;">
                                @csrf
                                <input type="hidden" name="wilayah" value="{{ $item->wilayah }}">
                                <input type="hidden" name="tahun" value="{{ $item->tahun }}">
                                <input type="hidden" name="bulan" value="{{ $item->bulan }}">
                            </form>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ditemukan data yang cocok.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#dataRekap').DataTable();
    });
</script>
@endpush