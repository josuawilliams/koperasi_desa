<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $this->ensureSuperAdmin($request);

        $search = $request->search;
        $users = User::with('roles')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    public function block(Request $request, User $user): RedirectResponse
    {
        $this->ensureSuperAdmin($request);
        abort_if($request->user()->is($user), 403);

        $user->update(['is_blocked' => true]);

        return redirect()->route('users.index')->with('success', 'User berhasil diblokir');
    }

    public function unblock(Request $request, User $user): RedirectResponse
    {
        $this->ensureSuperAdmin($request);

        $user->update(['is_blocked' => false]);

        return redirect()->route('users.index')->with('success', 'User berhasil diunblokir');
    }

    private function ensureSuperAdmin(Request $request): void
    {
        abort_unless($request->user()->hasRole('super_admin'), 403);
    }
}
