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
    @empty
    @endforelse

    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header" style="border-bottom: solid #034871 2px ;">
                    <img src="{{ asset('images/logo.png') }}" style="height:35px;">
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