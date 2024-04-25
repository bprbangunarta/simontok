<table>
    <thead>
        <tr>
            <th style="width: 50px;font-weight: bold;text-align: center;">No</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Kredit</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Nama</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">HR-T</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Tgk. Pokok</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Tgk. Bunga</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Tgk. Denda</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Penanganan</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Wilayah</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Kelolaan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tugas as $item)
        <tr>
            <td style="text-align: center;">{{ $loop->iteration }}</td>
            <td>{{ $item->kredit->nokredit }}</td>
            <td>{{ $item->kredit->nama_debitur }}</td>
            <td>{{ $item->kredit->hari_tunggakan }}</td>
            <td>{{ $item->kredit->tunggakan->tunggakan_pokok }}</td>
            <td>{{ $item->kredit->tunggakan->tunggakan_bunga }}</td>
            <td>{{ $item->kredit->tunggakan->tunggakan_denda }}</td>
            <td>{{ $item->hasil }} ⇒ {{ $item->ket_hasil }}</td>
            <td>{{ $item->kredit->wilayah }}</td>
            <td>{{ $item->kredit->kode_petugas }}</td>
        </tr>
        @endforeach
    </tbody>
</table>