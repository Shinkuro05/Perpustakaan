<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $members = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('members.partials.table', compact('members'))->render(),
            ]);
        }

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:members',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:members|unique:users,email',
            'alamat' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create user account for member
        $user = User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'member',
        ]);

        Member::create([
            'user_id' => $user->id,
            'nim' => $validated['nim'],
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'alamat' => $validated['alamat'],
        ]);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function show(Member $member)
    {
        $member->load('loans.book', 'user');
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:members,nim,' . $member->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'alamat' => 'required|string',
        ]);

        $member->update($validated);

        if ($member->user) {
            $member->user->update([
                'name' => $validated['nama'],
                'email' => $validated['email'],
            ]);
        }

        return redirect()->route('members.index')->with('success', 'Anggota berhasil diperbarui!');
    }

    public function destroy(Member $member)
    {
        if ($member->activeLoans()->exists()) {
            return redirect()->route('members.index')->with('error', 'Anggota tidak dapat dihapus karena masih memiliki peminjaman aktif!');
        }

        $user = $member->user;
        $member->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus!');
    }

    public function search(Request $request)
    {
        $members = Member::where('nama', 'like', '%' . $request->q . '%')
            ->orWhere('nim', 'like', '%' . $request->q . '%')
            ->limit(10)
            ->get(['id', 'nim', 'nama', 'email']);

        return response()->json($members);
    }
}
