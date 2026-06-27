<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-slate-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">NIM</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider hidden md:table-cell">Email</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider hidden lg:table-cell">Alamat</th>
                <th class="text-center px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Peminjaman</th>
                <th class="text-center px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4">
                    <span class="font-mono text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-lg"><?php echo e($member->nim); ?></span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                            <?php echo e(strtoupper(substr($member->nama, 0, 1))); ?>

                        </div>
                        <span class="font-semibold text-slate-800 text-sm"><?php echo e($member->nama); ?></span>
                    </div>
                </td>
                <td class="px-6 py-4 hidden md:table-cell text-slate-500 text-sm"><?php echo e($member->email); ?></td>
                <td class="px-6 py-4 hidden lg:table-cell text-slate-500 text-sm max-w-xs truncate"><?php echo e($member->alamat); ?></td>
                <td class="px-6 py-4 text-center">
                    <span class="badge <?php echo e($member->activeLoans()->count() > 0 ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-500'); ?>">
                        <?php echo e($member->activeLoans()->count()); ?> aktif
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <a href="<?php echo e(route('members.show', $member)); ?>" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <a href="<?php echo e(route('members.edit', $member)); ?>" class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form method="POST" action="<?php echo e(route('members.destroy', $member)); ?>" onsubmit="return confirm('Hapus anggota ini?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" class="text-center py-12 text-slate-400">
                    <p class="text-sm">Tidak ada anggota ditemukan</p>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php /**PATH C:\Users\ArataShinkuro\Herd\Perpustakaan\resources\views/members/partials/table.blade.php ENDPATH**/ ?>