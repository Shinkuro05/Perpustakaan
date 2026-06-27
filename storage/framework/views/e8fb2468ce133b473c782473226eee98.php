

<?php $__env->startSection('title', 'Tambah Peminjaman'); ?>
<?php $__env->startSection('page-title', 'Tambah Peminjaman'); ?>
<?php $__env->startSection('page-subtitle', 'Catat transaksi peminjaman buku baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl">
    <div class="card p-6">
        <form method="POST" action="<?php echo e(route('loans.store')); ?>" id="loanForm" novalidate>
            <?php echo csrf_field(); ?>

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
                    <?php $__errorArgs = ['member_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                    <?php $__errorArgs = ['book_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Tanggal Pinjam -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pinjam <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                            value="<?php echo e(old('tanggal_pinjam', date('Y-m-d'))); ?>"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['tanggal_pinjam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['tanggal_pinjam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Kembali <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                            value="<?php echo e(old('tanggal_kembali', date('Y-m-d', strtotime('+7 days')))); ?>"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['tanggal_kembali'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['tanggal_kembali'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Catatan -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan <span class="text-slate-400 font-normal">(opsional)</span></label>
                    <textarea name="catatan" rows="3" placeholder="Catatan tambahan..."
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"><?php echo e(old('catatan')); ?></textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-slate-100">
                <button type="submit" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Peminjaman
                </button>
                <a href="<?php echo e(route('loans.index')); ?>" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
        fetch(`<?php echo e(route('members.search')); ?>?q=${encodeURIComponent(q)}`)
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
        fetch(`<?php echo e(route('books.search')); ?>?q=${encodeURIComponent(q)}`)
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ArataShinkuro\Herd\Perpustakaan\resources\views/loans/create.blade.php ENDPATH**/ ?>