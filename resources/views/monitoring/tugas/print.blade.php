<!DOCTYPE html>
<html>

<head>
    <title>Surat Tugas</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset('assets/print/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/print/AdminLTE.min.css') }}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body onload="window.print();">
    @forelse ($tugas as $index => $item)
    <section class="content">
        <img src="{{ asset('images/logo.png') }}" width="20%">
        <font style="float:right;font-weight: bold;font-size: 15px;">{{ $item->nama_debitur }}</font>

        <div class="row">
            <div class="col-md-12">
                <div>
                    <div class="box-body" style="font-size:10px;">
                        <center>
                            <b>
                                <font style="text-transform: uppercase;">SURAT TUGAS {{ $item->jenis }}</font></br>
                                <font style="text-transform: uppercase;">NO. ST/{{ $item->notugas }}/{{ date('d/m/Y') }}</font>
                            </b>
                        </center>
                        <table>
                            <thead>
                                <tr>
                                    <th>Yang bertanda tangan dibawah ini:</th>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama</td>
                                    <td> : {{ $item->leader->name }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
                                    <td> : {{ $item->leader->role }}</td>
                                </tr>
                                <tr>
                                    <th>Dengan ini menugaskan kepada:</th>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama</td>
                                    <td> : {{ $item->petugas->name }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
                                    <td> : {{ $item->petugas->role }}</td>
                                </tr>
                                <tr>
                                    <th>Untuk melakukan penagihan kepada:</th>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama</td>
                                    <td> : {{ $item->nama_debitur }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. Telepon</td>
                                    <td> : {{ $item->nohp }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alamat</td>
                                    <td> : {{ $item->alamat }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. Kredit</td>
                                    <td> : {{ $item->nokredit }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. Tabungan</td>
                                    <td> : {{ $item->notabungan }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Plafon</td>
                                    <td> : {{ $item->plafon }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tgl Jatuh Tempo</td>
                                    <td> : {{ $item->tgl_jatuh_tempo }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jumlah Tagihan</td>
                                    <td> : {{ $item->total_tunggakan }} (&nbsp;
                                        Pokok : {{ $item->pokok }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Bunga : {{ $item->bunga }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Denda : {{ $item->denda }} &nbsp;)</td>
                                </tr>
                            </thead>
                        </table>
                        <b>
                            <font>Demikian surat tugas penagihan ini agar dapat dilaksanakan dan dipergunakan sebagaimana mestinya.</font><br>
                            <center>
                                <font class="text-uppercase">{{ $kantor->nama }}, {{ $tanggal }}</font>
                            </center>
                        </b>
                    </div>

                    <div class="row" style="font-size:12px;">
                        <center>
                            <div class="col-lg-6 col-xs-6">
                                <div>
                                    <div class="inner">
                                        <font>Pemberi Tugas</font><br><br><br>
                                        <font>{{ $item->leader->name }}</font>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xs-6">
                                <div>
                                    <div class="inner">
                                        <font>Penerima Tugas</font><br><br><br>
                                        <font>{{ $item->petugas->name }}</font>
                                    </div>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
                <br>
                <center>
                    <div class="inner">
                        <font>Debitur</font><br><br><br>
                        <font>...............................</font>
                    </div>
                </center>
                <p></p>
            </div>
        </div>
    </section>
    @empty
    @endforelse

    <div style="page-break-before: always;"></div>

    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header" style="border-bottom: solid #034871 2px ;">
                    <img src="https://simontok.bprbangunarta.co.id/assets/img/banner.png" style="height:35px;">
                </h2>
            </div>
        </div>
        <br>
        <div style="margin-top: -100px;">
            <table>
                <tr>
                    <td><b>{{ $item->leader->role }}</b></td>
                    <td>&nbsp; : &nbsp; {{ $item->leader->name }}</td>
                </tr>
                <tr>
                    <td><b>Wilayah Operasional</b></td>
                    <td>&nbsp; : &nbsp; {{ $kantor->nama }}</td>
                </tr>
            </table>
        </div>
        <br>

        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" width="4%">No</th>
                            <th class="text-center" width="12%">Tanggal</th>
                            <th class="text-center">Kredit</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Petugas</th>
                            <th class="text-center">Jenis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tugas as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $item->tanggal }}</td>
                            <td>{{ $item->nokredit }}</td>
                            <td>{{ $item->nama_debitur }}</td>
                            <td>{{ $item->petugas->name }}</td>
                            <td>{{ $item->jenis }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <div class="text-uppercase text-center"><b>{{ $kantor->nama }}, {{ $tanggal }}</b></div>
            <p></p>

            <table class="table">
                <tr>
                    @php
                    $previousPetugasIds = [];
                    @endphp

                    @foreach ($tugas as $item)
                    @if (!in_array($item->petugas->id, $previousPetugasIds))
                    <td class="text-center">
                        {{ $item->petugas->role }}<br><br><br>
                        <b>{{ $item->petugas->name }}</b>
                    </td>
                    @php
                    $previousPetugasIds[] = $item->petugas->id;
                    @endphp
                    @endif
                    @endforeach
                </tr>
            </table>
            <div class="text-center">
                {{ $item->leader->role }},<br><br><br>
                <b>{{ $item->leader->name }}</b>
            </div>
        </div>
    </section>
</body>

</html>