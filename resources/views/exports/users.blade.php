<table>
    <thead>
        <tr>
            <th style="width: 50px;font-weight: bold;text-align: center;">No</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Name</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Username</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Phone</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Email</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Role</th>
            <th style="width: 100px;font-weight: bold;text-align: center;">Password</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->password }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
