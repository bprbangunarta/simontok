<table>
    <thead>
        <tr>
            <th style="width: 50px;font-weight: bold;text-align: center;">NO</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">NO. KREDIT</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">NAMA DEBITUR</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">WILAYAH</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">PETUGAS</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">TANGGAL</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">PELAKSANAAN</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">DETAIL PELAKSANAAN</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">HASIL</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">JB</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">DETAIL HASIL</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">CATATAN</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">KLASIFIKASI</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kredit as $item)
        <tr>
            <td style="text-align: center;">{{ $loop->iteration }}</td>
            <td>{{ $item->nokredit }}</td>
            <td>{{ $item->nama_debitur }}</td>
            <td>{{ $item->wilayah }}</td>
            <td style="text-align: center;">{{ $item->kode_petugas }}</td>
            <td style="text-align: center;">{{ $item->tanggal }}</td>
            <td>{{ $item->pelaksanaan }}</td>
            <td>{{ $item->ket_pelaksanaan }}</td>
            <td>{{ $item->hasil }}</td>
            <td style="text-align: center;">{{ $item->janji_tanggal }}</td>
            <td>{{ $item->ket_hasil }}</td>
            <td>{{ $item->catatan_leader }}</td>
            <td style="text-align: center;">{{ $item->klasifikasi }}</td>
        </tr>
        @endforeach
    </tbody>
</table>