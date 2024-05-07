<table>
    <thead>
        <tr>
            <th style="width: 50px;font-weight: bold;text-align: center;">No</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Kredit</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Nama</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Petugas</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Tanggal</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Jenis</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Pelaksanaan</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Ket. Pelaksanaan</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Hasil</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Ket. Hasil</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Catatan Leader</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Foto</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tugas as $item)
        <tr>
            <td style="text-align: center;">{{ $loop->iteration }}</td>
            <td>{{ $item->nokredit }}</td>
            <td>{{ $item->nama_debitur }}</td>
            <td>{{ $item->petugas->name }}</td>
            <td>{{ $item->tanggal }}</td>
            <td>{{ $item->jenis }}</td>
            <td>{{ $item->pelaksanaan }}</td>
            <td>{{ $item->ket_pelaksanaan }}</td>
            <td>{{ $item->hasil }}</td>
            <td>{{ $item->ket_hasil }}</td>
            <td>{{ $item->catatan_leader }}</td>
            <td>{{ $item->foto_pelaksanaan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>