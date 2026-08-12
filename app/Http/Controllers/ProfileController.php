<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->fill([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ])->save();

        return back()->with('status', 'Profil berhasil diperbarui.');
    }
}
