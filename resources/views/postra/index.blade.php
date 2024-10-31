@extends('layouts.app')
@section('title', 'Data Postra')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div class="card-body" style="margin-top: -20px;">
            <div class="table-responsive text-nowrap mb-3">
                <table class="table" id="dataRekap" style="font-size: 13px;">
                    <thead class="fw-bold">
                        <tr>
                            <th>No. Kredit</th>
                            <th>Nama Debitur</th>
                            <th>Alamat</th>
                            <th>Plafon</th>
                            <th>Realisasi</th>
                            <th>No. HP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kredit as $item)
                        <tr class="{{ $item->status == false ? '' : 'table-success' }}">
                            <td>
                                <a href="{{ route('postra.show', $item->noacc) }}">{{ $item->noacc }}</a>
                            </td>
                            <td>{{ $item->fname }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>Rp {{ number_format($item->plafond_awal, 0, ',', '.') }}</td>
                            <td>{{ $item->tgleff }}</td>
                            <td>{{ $item->nohp }}</td>
                        </tr>
                        @endforeach
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
        $('#dataRekap').DataTable({
            "paging": true,
            "info": true
        });
    });
</script>
@endpush