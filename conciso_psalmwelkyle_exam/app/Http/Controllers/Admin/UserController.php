<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'Guest')
            ->orWhere('id', auth()->id())
            ->get();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'you cannot deactivate your own account');
        }

        $user->update(['is_active' => false]);

        return redirect()->route('admin.users.index')->with('success', 'User deactivated successfully.');
    }
}