<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('kode_buku', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $kategoris = Book::distinct()->pluck('kategori')->filter()->sort()->values();

        // AJAX request for search
        if ($request->ajax()) {
            return response()->json([
                'html' => view('books.partials.table', compact('books'))->render(),
                'pagination' => view('books.partials.pagination', compact('books'))->render(),
            ]);
        }

        return view('books.index', compact('books', 'kategoris'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|string|max:20|unique:books',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'kategori' => 'required|string|max:100',
            'stok' => 'required|integer|min:1',
        ]);

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(Book $book)
    {
        $book->load('loans.member');
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|string|max:20|unique:books,kode_buku,' . $book->id,
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'kategori' => 'required|string|max:100',
            'stok' => 'required|integer|min:1',
        ]);

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        if ($book->activeLoans()->exists()) {
            return redirect()->route('books.index')->with('error', 'Buku tidak dapat dihapus karena masih dipinjam!');
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus!');
    }

    public function search(Request $request)
    {
        $books = Book::where('judul', 'like', '%' . $request->q . '%')
            ->orWhere('kode_buku', 'like', '%' . $request->q . '%')
            ->limit(10)
            ->get(['id', 'kode_buku', 'judul', 'penulis', 'stok']);

        return response()->json($books);
    }
}
