<table>
    <thead>
        <tr>
            <th style="width: 50px;font-weight: bold;text-align: center;">NO</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">NO. KREDIT</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">NO. SPK</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">NAMA DEBITUR</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">WILAYAH</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">PLAFON</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">BAKI DEBET</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">COL</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">METODE RPS</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">JK</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">BUNGA</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">TGL. REALISASI</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">JTH. TEMPO</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">HR</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">PETUGAS</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">KLASIFIKASI</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kredit as $item)
        <tr>
            <td style="text-align: center;">{{ $loop->iteration }}</td>
            <td>{{ $item->nokredit }}</td>
            <td>{{ $item->nospk }}</td>
            <td>{{ $item->nama_debitur }}</td>
            <td>{{ $item->wilayah }}</td>
            <td style="text-align: right;">{{ number_format($item->plafon, 0, ',', '.') }}</td>
            <td style="text-align: right;">{{ number_format($item->baki_debet, 0, ',', '.') }}</td>
            <td style="text-align: center;">{{ $item->kolektibilitas }}</td>
            <td>{{ $item->metode_rps }}</td>
            <td style="text-align: center;">{{ $item->jangka_waktu }}</td>
            <td style="text-align: center;">{{ $item->rate_bunga }}</td>
            <td style="text-align: center;">{{ $item->tgl_realisasi }}</td>
            <td style="text-align: center;">{{ $item->tgl_jatuh_tempo }}</td>
            <td style="text-align: center;">{{ $item->hari_tunggakan }}</td>
            <td style="text-align: center;">{{ $item->kode_petugas }}</td>
            <td style="text-align: center;">{{ $item->klasifikasi }}</td>
        </tr>
        @endforeach
    </tbody>
</table>