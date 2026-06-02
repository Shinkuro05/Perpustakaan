@extends('layouts.app')

@section('title', 'Peminjaman Saya')
@section('page-title', 'Peminjaman Saya')
@section('page-subtitle', 'Riwayat seluruh peminjaman buku')

@section('content')

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Buku</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider hidden sm:table-cell">Tgl Pinjam</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider hidden sm:table-cell">Tgl Kembali</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider hidden md:table-cell">Denda</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($loans as $loan)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800 text-sm">{{ $loan->book->judul ?? '-' }}</p>
                        <p class="text-slate-400 text-xs">{{ $loan->book->penulis ?? '' }}</p>
                    </td>
                    <td class="px-6 py-4 hidden sm:table-cell text-slate-500 text-sm">{{ $loan->tanggal_pinjam->format('d M Y') }}</td>
                    <td class="px-6 py-4 hidden sm:table-cell text-slate-500 text-sm">
                        {{ $loan->tanggal_kembali->format('d M Y') }}
                        @if($loan->tanggal_dikembalikan)
                        <p class="text-xs text-emerald-600">Kembali: {{ $loan->tanggal_dikembalikan->format('d M Y') }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="badge {{ $loan->status_badge }}">{{ ucfirst($loan->status) }}</span>
                    </td>
                    <td class="px-6 py-4 text-right hidden md:table-cell">
                        @if($loan->denda > 0)
                        <span class="text-red-600 font-semibold text-sm">Rp{{ number_format($loan->denda, 0, ',', '.') }}</span>
                        @else
                        <span class="text-slate-300 text-sm">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-12 text-slate-400">
                        <p class="text-sm">Belum ada riwayat peminjaman</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-5">{{ $loans->links() }}</div>

@endsection
