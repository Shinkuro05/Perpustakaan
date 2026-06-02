<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Loan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Book::count();
        $totalAnggota = Member::count();
        $totalPeminjaman = Loan::count();
        $peminjamanAktif = Loan::whereIn('status', ['dipinjam', 'terlambat'])->count();
        $terlambat = Loan::where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', Carbon::today())
            ->count();

        $peminjamanTerbaru = Loan::with(['member', 'book'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $bukuPopuler = Book::withCount('loans')
            ->orderBy('loans_count', 'desc')
            ->limit(5)
            ->get();

        // Update overdue status
        Loan::where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', Carbon::today())
            ->update(['status' => 'terlambat']);

        return view('dashboard', compact(
            'totalBuku', 'totalAnggota', 'totalPeminjaman',
            'peminjamanAktif', 'terlambat', 'peminjamanTerbaru', 'bukuPopuler'
        ));
    }

    public function memberDashboard()
    {
        $member = auth()->user()->member;

        if (!$member) {
            return view('member.no-profile');
        }

        $peminjamanAktif = Loan::where('member_id', $member->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->with('book')
            ->get();

        $riwayat = Loan::where('member_id', $member->id)
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('member.dashboard', compact('member', 'peminjamanAktif', 'riwayat'));
    }
}
