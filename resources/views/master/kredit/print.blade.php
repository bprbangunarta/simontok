<!DOCTYPE html>
<html>

<head>
    <title>Kartu Monitoring Debitur</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset('assets/print/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/print/AdminLTE.min.css') }}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body onload="window.print();">
    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <img src="{{ asset('images/logo.png') }}" style="height:35px;">
                    <p class="pull-right" style="margin-top: 7px;">NO. {{ $kredit->nospk }}</p>
                </h2>
            </div>
        </div>
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <div class="table-responsive">
                    <table>
                        <tr>
                            <td><b>Name</b></td>
                            <td>&nbsp; : &nbsp; {{ $kredit->nama_debitur }}</td>
                        </tr>
                        <tr>
                            <td><b>No. Telp</b></td>
                            <td>&nbsp; : &nbsp; {{ $cif->nohp }}</td>
                        </tr>
                        <tr>
                            <td><b>Wilayah</b></td>
                            <td>&nbsp; : &nbsp; {{ $kredit->wilayah }}</td>
                        </tr>
                        <tr>
                            <td><b>Realisasi</b></td>
                            <td>&nbsp; : &nbsp; {{ $kredit->tgl_realisasi }}</td>
                        </tr>
                        <tr>
                            <td><b>Jth. Tempo</b></td>
                            <td>&nbsp; : &nbsp; {{ $kredit->tgl_jatuh_tempo }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-sm-4 invoice-col">
                <table>
                    <tr>
                        <td><b>No. Kredit</b></td>
                        <td>&nbsp; : &nbsp; {{ $kredit->nokredit }}</td>
                    </tr>
                    <tr>
                        <td><b>No. CIF</b></td>
                        <td>&nbsp; : &nbsp; {{ $kredit->nocif }}</td>
                    </tr>
                    <tr>
                        <td><b>Plafon</b></td>
                        <td>&nbsp; : &nbsp; {{ $kredit->plafon }}</td>
                    </tr>
                    <tr>
                        <td><b>Metode</b></td>
                        <td>&nbsp; : &nbsp; {{ $kredit->metode_rps }}</td>
                    </tr>
                    <tr>
                        <td><b>Rate</b></td>
                        <td>&nbsp; : &nbsp; {{ $kredit->rate_bunga }}%</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-4 invoice-col">
                <div class="table-responsive">
                    <table>
                        <tr>
                            <td><b>JW</b></td>
                            <td>&nbsp; : &nbsp; {{ $kredit->jangka_waktu }} Bulan</td>
                        </tr>
                        <tr>
                            <td><b>Alamat</b></td>
                            <td>&nbsp; : &nbsp; {{ $kredit->wilayah }}</td>
                        </tr>
                    </table>
                    {{ $kredit->alamat }}
                </div>
            </div>
        </div>
        <p></p>

        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <p class="text-center" style="font-weight:bold;font-size:15px;">AGUNAN KREDIT</p>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-bordered" style="font-size: 12px;">
                    <tbody>
                        @forelse ($kredit->agunan as $index => $item)
                        <tr>
                            <td class="text-center" width="5%" style="vertical-align: middle;">{{ $index + 1 }}</td>
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
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <p class="text-center" style="font-weight:bold;font-size:15px;">PENANGANAN KREDIT</p>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-bordered" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th class="text-center" width="12%">Tanggal</th>
                            <th class="text-center" width="13%">Petugas</th>
                            <th class="text-center">Pelaksanaan</th>
                            <th class="text-center" width="25%">Hasil</th>
                            <th class="text-center" width="23%">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tugas as $index => $item)
                        <tr>
                            <td class="text-center">{{ $item->tanggal }}</td>
                            <td>{{ $item->petugas->name }}</td>
                            <td>{{ $item->pelaksanaan }}</td>
                            <td>{{ $item->hasil }}</td>
                            <td>{{ $item->catatan_leader }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="10">Tidak ada penanganan kredit</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>

</html>