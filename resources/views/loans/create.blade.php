@extends('layouts.app')

@section('title', 'Tambah Peminjaman')
@section('page-title', 'Tambah Peminjaman')
@section('page-subtitle', 'Catat transaksi peminjaman buku baru')

@section('content')
<div class="max-w-2xl">
    <div class="card p-6">
        <form method="POST" action="{{ route('loans.store') }}" id="loanForm" novalidate>
            @csrf

            <div class="space-y-5">

                <!-- Anggota (AJAX search) -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Anggota <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="text" id="memberSearch" placeholder="Ketik nama atau NIM anggota..."
                            autocomplete="off"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="memberDropdown" class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg hidden max-h-48 overflow-y-auto"></div>
                    </div>
                    <input type="hidden" name="member_id" id="member_id">
                    <p id="memberSelected" class="text-green-600 text-xs mt-1 hidden"></p>
                    <p id="memberError" class="text-red-500 text-xs mt-1 hidden">Pilih anggota terlebih dahulu</p>
                    @error('member_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Buku (AJAX search) -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Buku <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="text" id="bookSearch" placeholder="Ketik judul atau kode buku..."
                            autocomplete="off"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="bookDropdown" class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg hidden max-h-48 overflow-y-auto"></div>
                    </div>
                    <input type="hidden" name="book_id" id="book_id">
                    <p id="bookSelected" class="text-green-600 text-xs mt-1 hidden"></p>
                    <p id="bookError" class="text-red-500 text-xs mt-1 hidden">Pilih buku terlebih dahulu</p>
                    @error('book_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Tanggal Pinjam -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pinjam <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                            value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_pinjam') border-red-400 @enderror">
                        @error('tanggal_pinjam')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Kembali <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                            value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_kembali') border-red-400 @enderror">
                        @error('tanggal_kembali')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Catatan -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan <span class="text-slate-400 font-normal">(opsional)</span></label>
                    <textarea name="catatan" rows="3" placeholder="Catatan tambahan..."
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('catatan') }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-slate-100">
                <button type="submit" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Peminjaman
                </button>
                <a href="{{ route('loans.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ---- AJAX Member Search ----
let memberTimer;
const memberSearch = document.getElementById('memberSearch');
const memberDropdown = document.getElementById('memberDropdown');

memberSearch.addEventListener('input', function() {
    clearTimeout(memberTimer);
    const q = this.value.trim();
    if (q.length < 2) { memberDropdown.classList.add('hidden'); return; }
    memberTimer = setTimeout(() => {
        fetch(`{{ route('members.search') }}?q=${encodeURIComponent(q)}`)
            .then(r => r.json())
            .then(data => {
                if (!data.length) {
                    memberDropdown.innerHTML = '<div class="px-4 py-3 text-sm text-slate-400">Tidak ditemukan</div>';
                } else {
                    memberDropdown.innerHTML = data.map(m =>
                        `<div class="px-4 py-3 text-sm hover:bg-slate-50 cursor-pointer border-b border-slate-50 last:border-0"
                              onclick="selectMember(${m.id}, '${escapeHtml(m.nama)}', '${escapeHtml(m.nim)}')">
                            <span class="font-semibold text-slate-800">${m.nama}</span>
                            <span class="text-slate-400 ml-2">${m.nim}</span>
                        </div>`
                    ).join('');
                }
                memberDropdown.classList.remove('hidden');
            });
    }, 300);
});

function selectMember(id, nama, nim) {
    document.getElementById('member_id').value = id;
    memberSearch.value = `${nama} (${nim})`;
    document.getElementById('memberSelected').textContent = `✓ ${nama}`;
    document.getElementById('memberSelected').classList.remove('hidden');
    document.getElementById('memberError').classList.add('hidden');
    memberDropdown.classList.add('hidden');
}

// ---- AJAX Book Search ----
let bookTimer;
const bookSearch = document.getElementById('bookSearch');
const bookDropdown = document.getElementById('bookDropdown');

bookSearch.addEventListener('input', function() {
    clearTimeout(bookTimer);
    const q = this.value.trim();
    if (q.length < 2) { bookDropdown.classList.add('hidden'); return; }
    bookTimer = setTimeout(() => {
        fetch(`{{ route('books.search') }}?q=${encodeURIComponent(q)}`)
            .then(r => r.json())
            .then(data => {
                if (!data.length) {
                    bookDropdown.innerHTML = '<div class="px-4 py-3 text-sm text-slate-400">Tidak ditemukan</div>';
                } else {
                    bookDropdown.innerHTML = data.map(b => {
                        const avail = b.stok; // simplified
                        return `<div class="px-4 py-3 text-sm hover:bg-slate-50 cursor-pointer border-b border-slate-50 last:border-0"
                                      onclick="selectBook(${b.id}, '${escapeHtml(b.judul)}', '${escapeHtml(b.kode_buku)}')">
                            <span class="font-semibold text-slate-800">${b.judul}</span>
                            <span class="text-slate-400 ml-2 text-xs">${b.kode_buku}</span>
                            <span class="text-slate-400 text-xs ml-1">• ${b.penulis}</span>
                        </div>`;
                    }).join('');
                }
                bookDropdown.classList.remove('hidden');
            });
    }, 300);
});

function selectBook(id, judul, kode) {
    document.getElementById('book_id').value = id;
    bookSearch.value = `${judul} (${kode})`;
    document.getElementById('bookSelected').textContent = `✓ ${judul}`;
    document.getElementById('bookSelected').classList.remove('hidden');
    document.getElementById('bookError').classList.add('hidden');
    bookDropdown.classList.add('hidden');
}

// Close dropdowns on outside click
document.addEventListener('click', function(e) {
    if (!memberSearch.contains(e.target)) memberDropdown.classList.add('hidden');
    if (!bookSearch.contains(e.target)) bookDropdown.classList.add('hidden');
});

function escapeHtml(str) {
    return str.replace(/'/g, "\\'").replace(/"/g, '&quot;');
}

// ---- Date Validation & Form Validation ----
document.getElementById('tanggal_pinjam').addEventListener('change', function() {
    const pinjam = this.value;
    const kembali = document.getElementById('tanggal_kembali');
    if (kembali.value && kembali.value <= pinjam) {
        const next = new Date(pinjam);
        next.setDate(next.getDate() + 7);
        kembali.value = next.toISOString().split('T')[0];
    }
    kembali.min = pinjam;
});

document.getElementById('loanForm').addEventListener('submit', function(e) {
    let valid = true;

    if (!document.getElementById('member_id').value) {
        document.getElementById('memberError').classList.remove('hidden');
        valid = false;
    }
    if (!document.getElementById('book_id').value) {
        document.getElementById('bookError').classList.remove('hidden');
        valid = false;
    }

    const pinjam = document.getElementById('tanggal_pinjam').value;
    const kembali = document.getElementById('tanggal_kembali').value;
    if (!pinjam || !kembali) { valid = false; }
    if (pinjam && kembali && kembali <= pinjam) {
        alert('Tanggal kembali harus setelah tanggal pinjam!');
        valid = false;
    }

    if (!valid) e.preventDefault();
});
</script>
@endpush
