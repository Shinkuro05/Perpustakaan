@extends('layouts.app')

@section('title', 'Data Anggota')
@section('page-title', 'Data Anggota')
@section('page-subtitle', 'Kelola data anggota perpustakaan')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div class="relative sm:w-72">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" id="searchInput" placeholder="Cari nama, NIM, email..." value="{{ request('search') }}"
            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <a href="{{ route('members.create') }}" class="btn-primary whitespace-nowrap">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Anggota
    </a>
</div>

<div class="card overflow-hidden">
    <div id="membersTable">
        @include('members.partials.table', ['members' => $members])
    </div>
</div>

<div class="mt-5">{{ $members->links() }}</div>

@endsection

@push('scripts')
<script>
let t;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(t);
    t = setTimeout(() => {
        fetch(`{{ route('members.index') }}?search=${this.value}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            document.getElementById('membersTable').innerHTML = data.html;
        });
    }, 400);
});
</script>
@endpush
