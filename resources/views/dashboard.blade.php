@extends('layouts.app')

@section('title', 'Dashboard - Perpustakaan')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data perpustakaan hari ini')

@section('content')

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <!-- Buku -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <span class="badge bg-blue-100 text-blue-700">Koleksi</span>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $totalBuku }}</p>
        <p class="text-slate-500 text-sm mt-1">Total Buku</p>
    </div>

    <!-- Anggota -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <span class="badge bg-emerald-100 text-emerald-700">Aktif</span>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $totalAnggota }}</p>
        <p class="text-slate-500 text-sm mt-1">Total Anggota</p>
    </div>

    <!-- Peminjaman -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-violet-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <span class="badge bg-violet-100 text-violet-700">Total</span>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $totalPeminjaman }}</p>
        <p class="text-slate-500 text-sm mt-1">Total Peminjaman</p>
    </div>

    <!-- Terlambat -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="badge bg-red-100 text-red-700">Peringatan</span>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $terlambat }}</p>
        <p class="text-slate-500 text-sm mt-1">Terlambat Kembali</p>
    </div>
</div>

<!-- Bottom section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Peminjaman Terbaru -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-slate-800 font-bold">Peminjaman Terbaru</h2>
            <a href="{{ route('loans.index') }}" class="text-blue-600 text-sm font-medium hover:text-blue-800">Lihat semua →</a>
        </div>
        <div class="space-y-3">
            @forelse($peminjamanTerbaru as $loan)
            <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors">
                <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr($loan->member->nama ?? '?', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-slate-800 text-sm font-semibold truncate">{{ $loan->book->judul ?? '-' }}</p>
                    <p class="text-slate-400 text-xs truncate">{{ $loan->member->nama ?? '-' }} • Kembali: {{ $loan->tanggal_kembali->format('d M Y') }}</p>
                </div>
                <span class="badge {{ $loan->status_badge }} flex-shrink-0">{{ ucfirst($loan->status) }}</span>
            </div>
            @empty
            <p class="text-slate-400 text-sm text-center py-4">Belum ada peminjaman</p>
            @endforelse
        </div>
    </div>

    <!-- Buku Populer -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-slate-800 font-bold">Buku Terpopuler</h2>
            <a href="{{ route('books.index') }}" class="text-blue-600 text-sm font-medium hover:text-blue-800">Lihat semua →</a>
        </div>
        <div class="space-y-3">
            @forelse($bukuPopuler as $index => $book)
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 flex-shrink-0 rounded-full {{ $index === 0 ? 'bg-amber-400' : ($index === 1 ? 'bg-slate-300' : ($index === 2 ? 'bg-orange-400' : 'bg-slate-100')) }} flex items-center justify-center text-xs font-bold {{ $index < 3 ? 'text-white' : 'text-slate-500' }}">
                    {{ $index + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-slate-800 text-sm font-semibold truncate">{{ $book->judul }}</p>
                    <p class="text-slate-400 text-xs">{{ $book->penulis }}</p>
                </div>
                <span class="text-slate-500 text-xs">{{ $book->loans_count }}x</span>
            </div>
            @empty
            <p class="text-slate-400 text-sm text-center py-4">Belum ada data peminjaman</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
