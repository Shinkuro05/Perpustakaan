

<?php $__env->startSection('title', 'Peminjaman Saya'); ?>
<?php $__env->startSection('page-title', 'Peminjaman Saya'); ?>
<?php $__env->startSection('page-subtitle', 'Riwayat seluruh peminjaman buku'); ?>

<?php $__env->startSection('content'); ?>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Buku</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider hidden sm:table-cell">Tgl Pinjam</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider hidden sm:table-cell">Tgl Kembali</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider hidden md:table-cell">Denda</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800 text-sm"><?php echo e($loan->book->judul ?? '-'); ?></p>
                        <p class="text-slate-400 text-xs"><?php echo e($loan->book->penulis ?? ''); ?></p>
                    </td>
                    <td class="px-6 py-4 hidden sm:table-cell text-slate-500 text-sm"><?php echo e($loan->tanggal_pinjam->format('d M Y')); ?></td>
                    <td class="px-6 py-4 hidden sm:table-cell text-slate-500 text-sm">
                        <?php echo e($loan->tanggal_kembali->format('d M Y')); ?>

                        <?php if($loan->tanggal_dikembalikan): ?>
                        <p class="text-xs text-emerald-600">Kembali: <?php echo e($loan->tanggal_dikembalikan->format('d M Y')); ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="badge <?php echo e($loan->status_badge); ?>"><?php echo e(ucfirst($loan->status)); ?></span>
                    </td>
                    <td class="px-6 py-4 text-right hidden md:table-cell">
                        <?php if($loan->denda > 0): ?>
                        <span class="text-red-600 font-semibold text-sm">Rp<?php echo e(number_format($loan->denda, 0, ',', '.')); ?></span>
                        <?php else: ?>
                        <span class="text-slate-300 text-sm">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center py-12 text-slate-400">
                        <p class="text-sm">Belum ada riwayat peminjaman</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-5"><?php echo e($loans->links()); ?></div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ArataShinkuro\Herd\Perpustakaan\resources\views/member/loans.blade.php ENDPATH**/ ?>