@extends('layouts.app')

@section('title', 'Profil Tidak Ditemukan')
@section('page-title', 'Dashboard')

@section('content')
<div class="max-w-md mx-auto text-center py-16">
    <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    </div>
    <h2 class="text-xl font-bold text-slate-800 mb-2">Profil Anggota Tidak Ditemukan</h2>
    <p class="text-slate-500 text-sm">Akun Anda belum terdaftar sebagai anggota perpustakaan. Hubungi administrator untuk mendaftarkan profil anggota.</p>
</div>
@endsection
