<table>
    <thead>
        <tr>
            <th style="width: 50px;font-weight: bold;text-align: center;">No</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">No. Kredit</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">No. CIF</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">No. SPK</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Jenis</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Nama Debitur</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Wilayah</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Bidang</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Petugas</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Plafon</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Baki Debet</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Metode RPS</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">JW</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Realisasi</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Jth. Tempo</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Rate</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Coll</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Alamat</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Noacc Droping</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Kode Resort</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Tgk. Pokok</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Tgk. Bunga</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Tgk. Denda</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Tgk. Hari</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kredit as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nokredit }}</td>
            <td>{{ $item->nocif }}</td>
            <td>{{ $item->nospk }}</td>
            <td>{{ $item->produk_id }}</td>
            <td>{{ $item->nama_debitur }}</td>
            <td>{{ $item->wilayah }}</td>
            <td>{{ $item->bidang }}</td>
            <td style="text-transform: uppercase;">
                @if ($item->petugas)
                {{ $item->petugas->name }}
                @else
                <font style="color: red;">{{ $item->kode_petugas }}</font>
                @endif
            </td>
            <td>{{ $item->plafon }}</td>
            <td>{{ $item->baki_debet }}</td>
            <td>{{ $item->metode_rps }}</td>
            <td>{{ $item->jangka_waktu }}</td>
            <td>{{ $item->tgl_realisasi }}</td>
            <td>{{ $item->tgl_jatuh_tempo }}</td>
            <td>{{ $item->rate_bunga }}</td>
            <td>{{ $item->kolektibilitas }}</td>
            <td>{{ $item->alamat }}</td>
            <td>{{ $item->notabungan }}</td>
            <td>{{ $item->resort }}</td>
            <td>{{ $item->tunggakan->tunggakan_pokok }}</td>
            <td>{{ $item->tunggakan->tunggakan_bunga }}</td>
            <td>{{ $item->tunggakan->tunggakan_denda }}</td>
            <td>{{ $item->hari_tunggakan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>