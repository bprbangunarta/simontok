<table>
    <thead>
        <tr>
            <th style="width: 120px;font-weight: bold;text-align: center;">phone_number</th>
            <th style="width: 200px;font-weight: bold;text-align: center;">full_name</th>
            <th style="width: 200px;font-weight: bold;text-align: center;">customer_name</th>
            <th style="width: 200px;font-weight: bold;text-align: center;">date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kredit as $item)
        <tr>
            <td>{{ $item->nohp }}</td>
            <td>{{ $item->nama_debitur }}</td>
            <td>{{ $item->nama_debitur }}</td>
            <td>{{ $item->tgl_jatuh_tempo }}</td>
        </tr>
        @endforeach
    </tbody>
</table>