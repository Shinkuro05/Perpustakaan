

<?php $__env->startSection('title', $member->nama); ?>
<?php $__env->startSection('page-title', 'Detail Anggota'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl space-y-6">
    <div class="card p-6">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center text-white text-xl font-bold flex-shrink-0">
                <?php echo e(strtoupper(substr($member->nama, 0, 1))); ?>

            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800"><?php echo e($member->nama); ?></h2>
                <p class="text-slate-500 text-sm"><?php echo e($member->email); ?></p>
                <span class="badge bg-slate-100 text-slate-600 mt-1 inline-block">NIM: <?php echo e($member->nim); ?></span>
            </div>
        </div>
        <div class="bg-slate-50 rounded-xl p-4 mb-5">
            <p class="text-xs text-slate-400 mb-1">Alamat</p>
            <p class="text-slate-700 text-sm"><?php echo e($member->alamat); ?></p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('members.edit', $member)); ?>" class="btn-primary">Edit Anggota</a>
            <a href="<?php echo e(route('members.index')); ?>" class="btn-secondary">← Kembali</a>
        </div>
    </div>

    <div class="card p-6">
        <h3 class="font-bold text-slate-800 mb-4">Riwayat Peminjaman (<?php echo e($member->loans->count()); ?>)</h3>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $member->loans->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                <div>
                    <p class="font-semibold text-sm text-slate-800"><?php echo e($loan->book->judul ?? '-'); ?></p>
                    <p class="text-xs text-slate-400"><?php echo e($loan->tanggal_pinjam->format('d M Y')); ?> → <?php echo e($loan->tanggal_kembali->format('d M Y')); ?></p>
                </div>
                <div class="text-right">
                    <span class="badge <?php echo e($loan->status_badge); ?>"><?php echo e(ucfirst($loan->status)); ?></span>
                    <?php if($loan->denda > 0): ?>
                    <p class="text-xs text-red-600 mt-1">Denda: Rp<?php echo e(number_format($loan->denda, 0, ',', '.')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-slate-400 text-sm text-center py-4">Belum pernah meminjam</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ArataShinkuro\Herd\Perpustakaan\resources\views/members/show.blade.php ENDPATH**/ ?>