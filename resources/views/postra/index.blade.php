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

                    @forelse ($kredit as $item)
                    <tr class="{{ $item->tugas == null ? '' : 'table-success' }}">
                        <td>
                            @if ($item->tugas == null)
                            <a href="{{ route('postra.create', $item->nokredit) }}">
                                {{ $item->nokredit }}
                            </a>
                            @else
                            <a href="{{ route('postra.edit', $item->tugas) }}">
                                {{ $item->nokredit }}
                            </a>
                            @endif
                        </td>
                        <td>{{ $item->nama_debitur }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->plafon }}</td>
                        <td>{{ $item->tgl_realisasi }}</td>
                        <td>{{ $item->nohp }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Data tidak ditemukan</td>
                    </tr>
                    @endforelse
                </table>
            </div>

            <div class="row" style="margin-bottom: -30px;">
                <div class="col-sm-12 col-md-12">
                    <div>
                        <nav aria-label="Page navigation">
                            {{ $kredit->withQueryString()->onEachSide(0)->links('helper.pagination') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#dataRekap').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "searching": false,
            "lengthChange": false,
        });
    });
</script>
@endpush