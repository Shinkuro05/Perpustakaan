

<?php $__env->startSection('title', 'Peminjaman'); ?>
<?php $__env->startSection('page-title', 'Transaksi Peminjaman'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola peminjaman dan pengembalian buku'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div class="flex gap-3">
        <div class="relative sm:w-64">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="searchInput" placeholder="Cari anggota, buku..." value="<?php echo e(request('search')); ?>"
                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <select id="statusFilter" class="bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Status</option>
            <option value="dipinjam" <?php echo e(request('status') === 'dipinjam' ? 'selected' : ''); ?>>Dipinjam</option>
            <option value="dikembalikan" <?php echo e(request('status') === 'dikembalikan' ? 'selected' : ''); ?>>Dikembalikan</option>
            <option value="terlambat" <?php echo e(request('status') === 'terlambat' ? 'selected' : ''); ?>>Terlambat</option>
        </select>
    </div>
    <a href="<?php echo e(route('loans.create')); ?>" class="btn-primary whitespace-nowrap">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Peminjaman
    </a>
</div>

<div class="card overflow-hidden">
    <div id="loansTable">
        <?php echo $__env->make('loans.partials.table', ['loans' => $loans], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>

<div class="mt-5"><?php echo e($loans->links()); ?></div>

<!-- Return Modal -->
<div id="returnModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl">
        <h3 class="font-bold text-slate-800 mb-2">Konfirmasi Pengembalian</h3>
        <p class="text-slate-500 text-sm mb-5">Apakah buku ini sudah dikembalikan?</p>
        <div id="modalContent"></div>
        <div class="flex gap-3 mt-4">
            <button id="confirmReturn" class="btn-primary flex-1 justify-center">Ya, Kembalikan</button>
            <button onclick="closeModal()" class="btn-secondary flex-1 justify-center">Batal</button>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let t, currentLoanId;
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

document.getElementById('searchInput').addEventListener('input', debounceSearch);
document.getElementById('statusFilter').addEventListener('change', debounceSearch);

function debounceSearch() {
    clearTimeout(t);
    t = setTimeout(fetchLoans, 400);
}

function fetchLoans() {
    const params = new URLSearchParams({
        search: document.getElementById('searchInput').value,
        status: document.getElementById('statusFilter').value,
    });
    fetch(`<?php echo e(route('loans.index')); ?>?${params}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('loansTable').innerHTML = data.html;
    });
}

function openReturnModal(loanId, bookTitle, memberName) {
    currentLoanId = loanId;
    document.getElementById('modalContent').innerHTML = `
        <div class="bg-slate-50 rounded-xl p-3 text-sm">
            <p><strong>Buku:</strong> ${bookTitle}</p>
            <p><strong>Anggota:</strong> ${memberName}</p>
        </div>
    `;
    document.getElementById('returnModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('returnModal').classList.add('hidden');
    currentLoanId = null;
}

document.getElementById('confirmReturn').addEventListener('click', function() {
    if (!currentLoanId) return;
    this.textContent = 'Memproses...';
    this.disabled = true;

    fetch(`/loans/${currentLoanId}/return`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(r => r.json())
    .then(data => {
        closeModal();
        if (data.success) {
            fetchLoans();
            const denda = data.denda > 0 ? ` Denda: Rp${data.denda.toLocaleString('id-ID')}` : '';
            alert('Buku berhasil dikembalikan!' + denda);
        } else {
            alert(data.error || 'Terjadi kesalahan');
        }
    })
    .finally(() => {
        this.textContent = 'Ya, Kembalikan';
        this.disabled = false;
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ArataShinkuro\Herd\Perpustakaan\resources\views/loans/index.blade.php ENDPATH**/ ?>