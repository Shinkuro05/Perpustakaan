@extends('layouts.app')

@section('title', 'Tambah Anggota')
@section('page-title', 'Tambah Anggota')
@section('page-subtitle', 'Daftarkan anggota perpustakaan baru')

@section('content')
<div class="max-w-2xl">
    <div class="card p-6">
        <form method="POST" action="{{ route('members.store') }}" id="memberForm" novalidate>
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">NIM <span class="text-red-500">*</span></label>
                    <input type="text" name="nim" id="nim" value="{{ old('nim') }}" placeholder="2024001"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nim') border-red-400 @enderror">
                    @error('nim')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Nama lengkap"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-400 @enderror">
                    @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="email@contoh.com"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                    <textarea name="alamat" id="alamat" rows="3" placeholder="Alamat lengkap"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-400 @enderror resize-none">{{ old('alamat') }}</textarea>
                    @error('alamat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" placeholder="Min. 8 karakter"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-400 @enderror">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p id="passMatchErr" class="text-red-500 text-xs mt-1 hidden">Password tidak cocok</p>
                </div>
            </div>

            <div class="mt-4 p-3 bg-blue-50 rounded-xl text-sm text-blue-700">
                <strong>Info:</strong> Akun login akan dibuat otomatis dengan email dan password di atas.
            </div>

            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-slate-100">
                <button type="submit" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Anggota
                </button>
                <a href="{{ route('members.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('memberForm').addEventListener('submit', function(e) {
    let valid = true;
    const pass = document.getElementById('password').value;
    const passConf = document.getElementById('password_confirmation').value;
    const passErr = document.getElementById('passMatchErr');

    if (pass !== passConf) {
        passErr.classList.remove('hidden');
        valid = false;
    } else {
        passErr.classList.add('hidden');
    }

    const required = ['nim', 'nama', 'email', 'alamat', 'password'];
    required.forEach(f => {
        const el = document.getElementById(f);
        if (el && !el.value.trim()) {
            el.classList.add('border-red-400');
            valid = false;
        }
    });

    if (!valid) e.preventDefault();
});
</script>
@endpush
