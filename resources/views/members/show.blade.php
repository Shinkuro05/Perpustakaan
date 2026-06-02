@extends('layouts.app')

@section('title', $member->nama)
@section('page-title', 'Detail Anggota')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="card p-6">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center text-white text-xl font-bold flex-shrink-0">
                {{ strtoupper(substr($member->nama, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $member->nama }}</h2>
                <p class="text-slate-500 text-sm">{{ $member->email }}</p>
                <span class="badge bg-slate-100 text-slate-600 mt-1 inline-block">NIM: {{ $member->nim }}</span>
            </div>
        </div>
        <div class="bg-slate-50 rounded-xl p-4 mb-5">
            <p class="text-xs text-slate-400 mb-1">Alamat</p>
            <p class="text-slate-700 text-sm">{{ $member->alamat }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('members.edit', $member) }}" class="btn-primary">Edit Anggota</a>
            <a href="{{ route('members.index') }}" class="btn-secondary">← Kembali</a>
        </div>
    </div>

    <div class="card p-6">
        <h3 class="font-bold text-slate-800 mb-4">Riwayat Peminjaman ({{ $member->loans->count() }})</h3>
        <div class="space-y-3">
            @forelse($member->loans->take(10) as $loan)
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                <div>
                    <p class="font-semibold text-sm text-slate-800">{{ $loan->book->judul ?? '-' }}</p>
                    <p class="text-xs text-slate-400">{{ $loan->tanggal_pinjam->format('d M Y') }} → {{ $loan->tanggal_kembali->format('d M Y') }}</p>
                </div>
                <div class="text-right">
                    <span class="badge {{ $loan->status_badge }}">{{ ucfirst($loan->status) }}</span>
                    @if($loan->denda > 0)
                    <p class="text-xs text-red-600 mt-1">Denda: Rp{{ number_format($loan->denda, 0, ',', '.') }}</p>
                    @endif
                </div>
            </div>
            @empty
            <p class="text-slate-400 text-sm text-center py-4">Belum pernah meminjam</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
