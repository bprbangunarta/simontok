@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-sm-6 col-lg-6 mb-4">
            <div class="card card-border-shadow-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-cash ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">
                            @if ($kredit)
                            Rp. {{ $kredit->plafon }}
                            @else
                            Rp. 0
                            @endif
                        </h4>
                    </div>
                    <h5 class="card-title mb-0 pt-2">Plafon Kredit</h5>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-6 mb-4">
            <div class="card card-border-shadow-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-warning"><i class="ti ti-currency-dollar ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">
                            @if ($kredit)
                            Rp. {{ $kredit->baki_debet }}
                            @else
                            Rp. 0
                            @endif
                        </h4>
                    </div>
                    <h5 class="card-title mb-0 pt-2">Baki Debet</h5>

                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive mb-3" style="max-height: 500px; overflow-y: scroll;">
                <table class="table" style="font-size: 13px;">
                    <thead class="fw-bold">
                        <tr>
                            <td style="width:15%;">Janji Bayar</td>
                            <td>Nama Debitur</td>
                            <td>Komitmen</td>
                            <td>Wilayah</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($janji as $index => $item)
                        @if ($item->tanggal == \Carbon\Carbon::now()->format('Y-m-d'))
                        <tr class="table-warning">
                            @else
                        <tr>
                            @endif
                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd') }}
                                <br>
                                {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMMM Y') }}
                            </td>
                            <td>
                                {{ $item->kredit->nama_debitur }}
                                <br>
                                {{ $item->nokredit }}
                            </td>
                            <td>{{ $item->komitmen }}</td>
                            <td>
                                @if ($item->kredit->bidang == "REMEDIAL")
                                {{ $item->kredit->bidang }}
                                @else
                                {{ $item->kredit->wilayah }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row" style="margin-bottom: -30px;">
                <div class="col-sm-12 col-md-12">
                    <div>
                        <nav aria-label="Page navigation">
                            {{ $janji->withQueryString()->onEachSide(0)->links('helper.pagination') }}
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