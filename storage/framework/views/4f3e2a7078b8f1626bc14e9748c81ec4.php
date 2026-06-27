

<?php $__env->startSection('title', 'Data Buku - Perpustakaan'); ?>
<?php $__env->startSection('page-title', 'Data Buku'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola koleksi buku perpustakaan'); ?>

<?php $__env->startSection('content'); ?>

<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div class="flex gap-3">
        <div class="relative flex-1 sm:w-72">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="searchInput" placeholder="Cari buku, penulis, kode..." value="<?php echo e(request('search')); ?>"
                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <select id="kategoriFilter" class="bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Kategori</option>
            <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($kat); ?>" <?php echo e(request('kategori') === $kat ? 'selected' : ''); ?>><?php echo e($kat); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <a href="<?php echo e(route('books.create')); ?>" class="btn-primary whitespace-nowrap">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Buku
    </a>
</div>

<!-- Table -->
<div class="card overflow-hidden">
    <div id="booksTable">
        <?php echo $__env->make('books.partials.table', ['books' => $books], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>

<!-- Pagination -->
<div class="mt-5" id="paginationDiv">
    <?php echo e($books->links()); ?>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let searchTimeout;
const searchInput = document.getElementById('searchInput');
const kategoriFilter = document.getElementById('kategoriFilter');

function fetchBooks() {
    const params = new URLSearchParams({
        search: searchInput.value,
        kategori: kategoriFilter.value,
    });

    fetch(`<?php echo e(route('books.index')); ?>?${params}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('booksTable').innerHTML = data.html;
        document.getElementById('paginationDiv').innerHTML = data.pagination;
    });
}

searchInput.addEventListener('input', () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(fetchBooks, 400);
});

kategoriFilter.addEventListener('change', fetchBooks);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ArataShinkuro\Herd\Perpustakaan\resources\views/books/index.blade.php ENDPATH**/ ?>