@extends('layouts.app')

@section('title', $book->judul)
@section('page-title', 'Detail Buku')

@section('content')
<div class="max-w-3xl">
    <div class="card p-6 mb-6">
        <div class="flex items-start justify-between mb-5">
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $book->judul }}</h2>
                <p class="text-slate-500 text-sm mt-1">{{ $book->penulis }} • {{ $book->penerbit }}</p>
            </div>
            <span class="badge {{ $book->isAvailable() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $book->isAvailable() ? 'Tersedia' : 'Habis' }}
            </span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-slate-50 rounded-xl p-3"><p class="text-xs text-slate-400">Kode</p><p class="font-mono font-semibold text-sm mt-1">{{ $book->kode_buku }}</p></div>
            <div class="bg-slate-50 rounded-xl p-3"><p class="text-xs text-slate-400">Kategori</p><p class="font-semibold text-sm mt-1">{{ $book->kategori }}</p></div>
            <div class="bg-slate-50 rounded-xl p-3"><p class="text-xs text-slate-400">Tahun</p><p class="font-semibold text-sm mt-1">{{ $book->tahun_terbit }}</p></div>
            <div class="bg-slate-50 rounded-xl p-3"><p class="text-xs text-slate-400">Stok Tersedia</p><p class="font-semibold text-sm mt-1">{{ $book->availableStock() }}/{{ $book->stok }}</p></div>
        </div>
        <div class="flex gap-3 mt-5">
            <a href="{{ route('books.edit', $book) }}" class="btn-primary">Edit Buku</a>
            <a href="{{ route('books.index') }}" class="btn-secondary">← Kembali</a>
        </div>
    </div>

    <!-- Riwayat Peminjaman -->
    <div class="card p-6">
        <h3 class="font-bold text-slate-800 mb-4">Riwayat Peminjaman</h3>
        <div class="space-y-3">
            @forelse($book->loans->take(10) as $loan)
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                <div>
                    <p class="font-semibold text-sm text-slate-800">{{ $loan->member->nama ?? '-' }}</p>
                    <p class="text-xs text-slate-400">{{ $loan->tanggal_pinjam->format('d M Y') }} → {{ $loan->tanggal_kembali->format('d M Y') }}</p>
                </div>
                <span class="badge {{ $loan->status_badge }}">{{ ucfirst($loan->status) }}</span>
            </div>
            @empty
            <p class="text-slate-400 text-sm text-center py-4">Belum pernah dipinjam</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
