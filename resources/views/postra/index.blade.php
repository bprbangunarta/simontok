@extends('layouts.app')
@section('title', 'Data Postra')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer border-bottom">
            <div class="row mx-1">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length">
                        <button type="button" class="btn btn-outline-primary waves-effect">Data Postra</button>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1">
                        <div>
                            <form action="{{ route('postra.index') }}" method="GET">
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
                        <td>{{ number_format($item->plafon, 0, ',', '.') }}</td>
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