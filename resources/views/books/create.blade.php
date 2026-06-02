@extends('layouts.app')

@section('title', isset($book) ? 'Edit Buku' : 'Tambah Buku')
@section('page-title', isset($book) ? 'Edit Buku' : 'Tambah Buku')
@section('page-subtitle', isset($book) ? 'Perbarui data buku' : 'Tambah koleksi buku baru')

@section('content')

<div class="max-w-2xl">
    <div class="card p-6">
        <form method="POST" action="{{ isset($book) ? route('books.update', $book) : route('books.store') }}" id="bookForm" novalidate>
            @csrf
            @if(isset($book)) @method('PUT') @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Buku <span class="text-red-500">*</span></label>
                    <input type="text" name="kode_buku" id="kode_buku" value="{{ old('kode_buku', $book->kode_buku ?? '') }}"
                        placeholder="BK001"
                        class="form-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kode_buku') border-red-400 @enderror">
                    @error('kode_buku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Terbit <span class="text-red-500">*</span></label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit', $book->tahun_terbit ?? '') }}"
                        placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') }}"
                        class="form-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tahun_terbit') border-red-400 @enderror">
                    @error('tahun_terbit')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $book->judul ?? '') }}"
                        placeholder="Masukkan judul buku"
                        class="form-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('judul') border-red-400 @enderror">
                    @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Penulis <span class="text-red-500">*</span></label>
                    <input type="text" name="penulis" id="penulis" value="{{ old('penulis', $book->penulis ?? '') }}"
                        placeholder="Nama penulis"
                        class="form-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('penulis') border-red-400 @enderror">
                    @error('penulis')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Penerbit <span class="text-red-500">*</span></label>
                    <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit', $book->penerbit ?? '') }}"
                        placeholder="Nama penerbit"
                        class="form-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('penerbit') border-red-400 @enderror">
                    @error('penerbit')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" id="kategori"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kategori') border-red-400 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach(['Novel', 'Teknologi', 'Sejarah', 'Ekonomi', 'Psikologi', 'Sains', 'Pendidikan', 'Filsafat', 'Agama', 'Lainnya'] as $kat)
                        <option value="{{ $kat }}" {{ old('kategori', $book->kategori ?? '') === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                    @error('kategori')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" id="stok" value="{{ old('stok', $book->stok ?? 1) }}"
                        placeholder="1" min="1"
                        class="form-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stok') border-red-400 @enderror">
                    @error('stok')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

            </div>

            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-slate-100">
                <button type="submit" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ isset($book) ? 'Perbarui Buku' : 'Simpan Buku' }}
                </button>
                <a href="{{ route('books.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('bookForm').addEventListener('submit', function(e) {
    let valid = true;
    const required = ['kode_buku', 'judul', 'penulis', 'penerbit', 'tahun_terbit', 'stok'];

    required.forEach(field => {
        const el = document.getElementById(field);
        if (el && !el.value.trim()) {
            el.classList.add('border-red-400', 'ring-1', 'ring-red-400');
            valid = false;
        } else if (el) {
            el.classList.remove('border-red-400', 'ring-1', 'ring-red-400');
        }
    });

    const kategori = document.getElementById('kategori');
    if (!kategori.value) {
        kategori.classList.add('border-red-400');
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
        alert('Harap lengkapi semua field yang wajib diisi!');
    }
});
</script>
@endpush
