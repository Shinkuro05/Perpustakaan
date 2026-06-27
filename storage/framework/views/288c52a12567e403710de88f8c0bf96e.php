

<?php $__env->startSection('title', 'Dashboard Member'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('page-subtitle', 'Selamat datang, ' . auth()->user()->name); ?>

<?php $__env->startSection('content'); ?>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    <div class="card p-6">
        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <p class="text-3xl font-bold text-slate-800"><?php echo e($peminjamanAktif->count()); ?></p>
        <p class="text-slate-500 text-sm mt-1">Sedang Dipinjam</p>
    </div>
    <div class="card p-6">
        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-3xl font-bold text-slate-800"><?php echo e($riwayat->where('status', 'dikembalikan')->count()); ?></p>
        <p class="text-slate-500 text-sm mt-1">Sudah Dikembalikan</p>
    </div>
    <div class="card p-6">
        <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-3xl font-bold text-slate-800">3</p>
        <p class="text-slate-500 text-sm mt-1">Maks. Pinjam</p>
    </div>
</div>

<!-- Profile -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="card p-6">
        <h3 class="font-bold text-slate-800 mb-4">Profil Saya</h3>
        <div class="flex items-center gap-3 mb-4">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center text-white text-xl font-bold">
                <?php echo e(strtoupper(substr($member->nama, 0, 1))); ?>

            </div>
            <div>
                <p class="font-bold text-slate-800"><?php echo e($member->nama); ?></p>
                <p class="text-slate-500 text-xs"><?php echo e($member->nim); ?></p>
            </div>
        </div>
        <div class="space-y-2 text-sm">
            <div class="flex gap-2"><span class="text-slate-400 w-16 flex-shrink-0">Email</span><span class="text-slate-700"><?php echo e($member->email); ?></span></div>
            <div class="flex gap-2"><span class="text-slate-400 w-16 flex-shrink-0">Alamat</span><span class="text-slate-700"><?php echo e($member->alamat); ?></span></div>
        </div>
    </div>

    <!-- Peminjaman Aktif -->
    <div class="card p-6 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-800">Peminjaman Aktif</h3>
            <a href="<?php echo e(route('member.loans')); ?>" class="text-blue-600 text-sm hover:text-blue-800">Lihat semua →</a>
        </div>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $peminjamanAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-start justify-between p-4 bg-slate-50 rounded-xl">
                <div class="flex-1 min-w-0 mr-3">
                    <p class="font-semibold text-slate-800 text-sm truncate"><?php echo e($loan->book->judul ?? '-'); ?></p>
                    <p class="text-xs text-slate-400 mt-0.5"><?php echo e($loan->book->penulis ?? ''); ?></p>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs text-slate-500">Pinjam: <?php echo e($loan->tanggal_pinjam->format('d M Y')); ?></span>
                        <span class="text-xs <?php echo e($loan->isOverdue() ? 'text-red-600 font-semibold' : 'text-slate-500'); ?>">
                            Kembali: <?php echo e($loan->tanggal_kembali->format('d M Y')); ?>

                        </span>
                    </div>
                </div>
                <span class="badge <?php echo e($loan->status_badge); ?> flex-shrink-0"><?php echo e(ucfirst($loan->status)); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto text-slate-200 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                <p class="text-slate-400 text-sm">Tidak ada peminjaman aktif</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ArataShinkuro\Herd\Perpustakaan\resources\views/member/dashboard.blade.php ENDPATH**/ ?>