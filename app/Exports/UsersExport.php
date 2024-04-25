<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    public function view(): View
    {
        $users = User::all();

        return view('exports.users', [
            'users' => $users,
        ]);
    }
}
