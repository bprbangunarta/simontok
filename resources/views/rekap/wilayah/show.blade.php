@extends('layouts.app')
@section('title', 'Rekap Penanganan Wilayah')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div class="card-body" style="margin-top: -20px;">
            <div class="table-responsive text-nowrap mb-3">
                <table class="table" id="dataRekap" style="font-size: 13px;">
                    <thead class="fw-bold">
                        <tr>
                            <th>Tanggal</th>
                            <th>Kredit</th>
                            <th>Nama</th>
                            <th>Baki Debet</th>
                            <th>Tunggakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekap as $index => $item)
                        <tr>
                            <td>{{ $item->tanggal }}</td>
                            <td>
                                <a href="{{ route('kredit.show', $item->nokredit) }}">
                                    {{ $item->nokredit }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('kredit.show', $item->nokredit) }}">
                                    {{ $item->nama_debitur }}
                                </a>
                            </td>
                            <td>{{ $item->baki_debet }}</td>
                            <td>{{ $item->tunggakan_pokok }}</td>
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