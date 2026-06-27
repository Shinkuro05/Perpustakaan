

<?php $__env->startSection('title', 'Edit Buku'); ?>
<?php $__env->startSection('page-title', 'Edit Buku'); ?>
<?php $__env->startSection('page-subtitle', 'Perbarui data buku'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-2xl">
    <div class="card p-6">
        <form method="POST" action="<?php echo e(route('books.update', $book)); ?>" id="bookForm" novalidate>
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Buku <span class="text-red-500">*</span></label>
                    <input type="text" name="kode_buku" id="kode_buku" value="<?php echo e(old('kode_buku', $book->kode_buku)); ?>"
                        class="form-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['kode_buku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['kode_buku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Terbit <span class="text-red-500">*</span></label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" value="<?php echo e(old('tahun_terbit', $book->tahun_terbit)); ?>"
                        min="1900" max="<?php echo e(date('Y')); ?>"
                        class="form-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" id="judul" value="<?php echo e(old('judul', $book->judul)); ?>"
                        class="form-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Penulis <span class="text-red-500">*</span></label>
                    <input type="text" name="penulis" id="penulis" value="<?php echo e(old('penulis', $book->penulis)); ?>"
                        class="form-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Penerbit <span class="text-red-500">*</span></label>
                    <input type="text" name="penerbit" id="penerbit" value="<?php echo e(old('penerbit', $book->penerbit)); ?>"
                        class="form-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" id="kategori" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php $__currentLoopData = ['Novel', 'Teknologi', 'Sejarah', 'Ekonomi', 'Psikologi', 'Sains', 'Pendidikan', 'Filsafat', 'Agama', 'Lainnya']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($kat); ?>" <?php echo e(old('kategori', $book->kategori) === $kat ? 'selected' : ''); ?>><?php echo e($kat); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" id="stok" value="<?php echo e(old('stok', $book->stok)); ?>" min="1"
                        class="form-input w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-slate-100">
                <button type="submit" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Perbarui Buku
                </button>
                <a href="<?php echo e(route('books.index')); ?>" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ArataShinkuro\Herd\Perpustakaan\resources\views/books/edit.blade.php ENDPATH**/ ?>