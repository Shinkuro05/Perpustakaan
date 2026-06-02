@extends('layouts.app')

@section('title', 'Edit Peminjaman')
@section('page-title', 'Edit Peminjaman')
@section('page-subtitle', 'Perbarui data transaksi peminjaman')

@section('content')
<div class="max-w-2xl">
    <div class="card p-6">

        <!-- Info readonly -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 p-4 bg-slate-50 rounded-xl">
            <div>
                <p class="text-xs text-slate-400">Anggota</p>
                <p class="font-semibold text-slate-800 text-sm mt-0.5">{{ $loan->member->nama ?? '-' }}</p>
                <p class="text-xs text-slate-500">{{ $loan->member->nim ?? '' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400">Buku</p>
                <p class="font-semibold text-slate-800 text-sm mt-0.5">{{ $loan->book->judul ?? '-' }}</p>
                <p class="text-xs text-slate-500">{{ $loan->book->kode_buku ?? '' }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('loans.update', $loan) }}" id="editLoanForm" novalidate>
            @csrf @method('PUT')

            <div class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pinjam</label>
                        <input type="date" value="{{ $loan->tanggal_pinjam->format('Y-m-d') }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-slate-50 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Kembali <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                            value="{{ old('tanggal_kembali', $loan->tanggal_kembali->format('Y-m-d')) }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_kembali') border-red-400 @enderror">
                        @error('tanggal_kembali')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status" id="status"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-400 @enderror">
                        <option value="dipinjam" {{ old('status', $loan->status) === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="terlambat" {{ old('status', $loan->status) === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        <option value="dikembalikan" {{ old('status', $loan->status) === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Denda info (shown when dikembalikan selected) -->
                <div id="dendaInfo" class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-800 {{ old('status', $loan->status) !== 'dikembalikan' ? 'hidden' : '' }}">
                    <p class="font-semibold mb-1">⚠ Pengembalian</p>
                    <p>Tanggal dikembalikan akan diset ke hari ini. Denda dihitung otomatis Rp1.000/hari keterlambatan.</p>
                    @if($loan->denda > 0)
                    <p class="mt-1 font-semibold">Denda tercatat: Rp{{ number_format($loan->denda, 0, ',', '.') }}</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan</label>
                    <textarea name="catatan" rows="3" placeholder="Catatan tambahan..."
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('catatan', $loan->catatan) }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-slate-100">
                <button type="submit" class="btn-primary">Perbarui Data</button>
                <a href="{{ route('loans.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('status').addEventListener('change', function() {
    const info = document.getElementById('dendaInfo');
    this.value === 'dikembalikan' ? info.classList.remove('hidden') : info.classList.add('hidden');
});
</script>
@endpush
