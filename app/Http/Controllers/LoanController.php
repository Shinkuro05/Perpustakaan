<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with(['member', 'book']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('member', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%");
            })->orWhereHas('book', function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $loans = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('loans.partials.table', compact('loans'))->render(),
            ]);
        }

        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $books = Book::orderBy('judul')->get();
        $members = Member::orderBy('nama')->get();
        return view('loans.create', compact('books', 'members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'catatan' => 'nullable|string',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if (!$book->isAvailable()) {
            return back()->with('error', 'Stok buku tidak tersedia!')->withInput();
        }

        $member = Member::findOrFail($validated['member_id']);
        if ($member->activeLoans()->count() >= 3) {
            return back()->with('error', 'Anggota sudah meminjam maksimal 3 buku!')->withInput();
        }

        Loan::create([
            ...$validated,
            'user_id' => auth()->id(),
            'status' => 'dipinjam',
        ]);

        return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil dicatat!');
    }

    public function show(Loan $loan)
    {
        $loan->load(['member', 'book', 'user']);
        return view('loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        if ($loan->status === 'dikembalikan') {
            return redirect()->route('loans.index')->with('error', 'Peminjaman sudah dikembalikan, tidak bisa diedit!');
        }
        $books = Book::orderBy('judul')->get();
        $members = Member::orderBy('nama')->get();
        return view('loans.edit', compact('loan', 'books', 'members'));
    }

    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'tanggal_kembali' => 'required|date',
            'status' => 'required|in:dipinjam,dikembalikan,terlambat',
            'catatan' => 'nullable|string',
        ]);

        if ($validated['status'] === 'dikembalikan' && $loan->status !== 'dikembalikan') {
            $validated['tanggal_dikembalikan'] = Carbon::today();
            $denda = 0;
            $tglKembali = Carbon::parse($loan->tanggal_kembali);
            $tglDikembalikan = Carbon::today();
            if ($tglDikembalikan->gt($tglKembali)) {
                $days = $tglDikembalikan->diffInDays($tglKembali);
                $denda = $days * 1000;
            }
            $validated['denda'] = $denda;
        }

        $loan->update($validated);

        return redirect()->route('loans.index')->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    public function destroy(Loan $loan)
    {
        if ($loan->status !== 'dikembalikan') {
            return redirect()->route('loans.index')->with('error', 'Hanya peminjaman yang sudah dikembalikan yang bisa dihapus!');
        }

        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Data peminjaman berhasil dihapus!');
    }

    public function returnBook(Request $request, Loan $loan)
    {
        if ($loan->status === 'dikembalikan') {
            return response()->json(['error' => 'Buku sudah dikembalikan'], 400);
        }

        $tglKembali = Carbon::parse($loan->tanggal_kembali);
        $tglHariIni = Carbon::today();
        $denda = 0;

        if ($tglHariIni->gt($tglKembali)) {
            $days = $tglHariIni->diffInDays($tglKembali);
            $denda = $days * 1000;
        }

        $loan->update([
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => $tglHariIni,
            'denda' => $denda,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dikembalikan!',
            'denda' => $denda,
        ]);
    }

    public function memberLoans()
    {
        $member = auth()->user()->member;
        if (!$member) {
            return redirect()->route('member.dashboard');
        }

        $loans = Loan::where('member_id', $member->id)
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('member.loans', compact('loans'));
    }
}
