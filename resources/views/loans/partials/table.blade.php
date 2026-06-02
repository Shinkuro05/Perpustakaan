<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-slate-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Anggota</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Buku</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider hidden md:table-cell">Tgl Pinjam</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider hidden md:table-cell">Tgl Kembali</th>
                <th class="text-center px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                <th class="text-center px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($loans as $loan)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4">
                    <p class="font-semibold text-slate-800 text-sm">{{ $loan->member->nama ?? '-' }}</p>
                    <p class="text-slate-400 text-xs">{{ $loan->member->nim ?? '' }}</p>
                </td>
                <td class="px-6 py-4">
                    <p class="font-semibold text-slate-800 text-sm max-w-xs truncate">{{ $loan->book->judul ?? '-' }}</p>
                    <p class="text-slate-400 text-xs">{{ $loan->book->kode_buku ?? '' }}</p>
                </td>
                <td class="px-6 py-4 hidden md:table-cell text-slate-500 text-sm">{{ $loan->tanggal_pinjam->format('d M Y') }}</td>
                <td class="px-6 py-4 hidden md:table-cell">
                    <p class="text-sm {{ $loan->isOverdue() ? 'text-red-600 font-semibold' : 'text-slate-500' }}">
                        {{ $loan->tanggal_kembali->format('d M Y') }}
                    </p>
                    @if($loan->isOverdue())
                    <p class="text-xs text-red-500">{{ $loan->tanggal_kembali->diffInDays(now()) }} hari terlambat</p>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="badge {{ $loan->status_badge }}">{{ ucfirst($loan->status) }}</span>
                    @if($loan->denda > 0)
                    <p class="text-xs text-red-600 mt-0.5">Rp{{ number_format($loan->denda, 0, ',', '.') }}</p>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        @if(in_array($loan->status, ['dipinjam', 'terlambat']))
                        <button onclick="openReturnModal({{ $loan->id }}, '{{ addslashes($loan->book->judul ?? '') }}', '{{ addslashes($loan->member->nama ?? '') }}')"
                            class="badge bg-green-100 text-green-700 hover:bg-green-200 cursor-pointer transition-colors text-xs py-1 px-2 font-semibold">
                            Kembalikan
                        </button>
                        @endif
                        <a href="{{ route('loans.edit', $loan) }}" class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        @if($loan->status === 'dikembalikan')
                        <form method="POST" action="{{ route('loans.destroy', $loan) }}" onsubmit="return confirm('Hapus data peminjaman ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-12 text-slate-400">
                    <p class="text-sm">Tidak ada data peminjaman</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
