@extends('layouts.app')
@section('title', 'Rekap Penanganan Petugas')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">

        <div class="card-body" style="margin-top: -20px;">
            <div class="table-responsive text-nowrap mb-3">
                <table class="table" id="dataRekap" style="font-size: 13px;">
                    <thead class="fw-bold">
                        <tr>
                            <th>Petugas</th>
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
                            <td>{{ $item->petugas }}</td>
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
                                <a href="{{ route('rekap.petugas.show', ['id' => $item->id, 'tahun' => $item->tahun, 'bulan' => $item->bulan]) }}" class="btn btn-sm btn-primary" target="_blank">Detail</a>
                            </td>
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