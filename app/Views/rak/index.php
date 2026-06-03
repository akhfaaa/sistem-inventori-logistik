<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-[1400px] mx-auto px-6 py-8">
    
    <!-- Header Halaman -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Rak</h1>
            <p class="text-slate-500 mt-1 text-sm font-medium">Kelola titik lokasi penyimpanan fisik aset logistik di gudang.</p>
        </div>
        <button onclick="openModalRak()" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-slate-800 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Tambah Rak Baru
        </button>
    </div>

    <!-- Alert Notifikasi -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 font-bold rounded-xl border border-emerald-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Tabel Data Rak -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-widest">
                        <th class="p-5 font-bold w-16 text-center">No</th>
                        <th class="p-5 font-bold">Kode / Nama Rak</th>
                        <th class="p-5 font-bold">Detail Lokasi</th>
                        <th class="p-5 font-bold text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if(empty($rak)): ?>
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400 font-medium">Belum ada data lokasi rak yang terdaftar.</td>
                        </tr>
                    <?php else: $no = 1; foreach($rak as $r): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="p-5 text-center font-bold text-slate-400"><?= $no++ ?></td>
                            <td class="p-5">
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-amber-50 text-amber-700 font-bold rounded-lg border border-amber-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path></svg>
                                    <?= $r['nama_rak'] ?>
                                </span>
                            </td>
                            <td class="p-5 font-medium text-slate-600"><?= $r['lokasi'] ?></td>
                            <td class="p-5 text-center">
                                <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <!-- Tombol Edit -->
                                    <button onclick="editRak('<?= $r['id_rak'] ?>', '<?= $r['nama_rak'] ?>', '<?= $r['lokasi'] ?>')" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Edit Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <a href="<?= base_url('rak/delete/'.$r['id_rak']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus rak ini?')" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg transition-colors" title="Hapus Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= MODAL TAMBAH & EDIT RAK ================= -->
<div id="modalRak" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 hidden backdrop-blur-sm transition-all">
    <div class="bg-white rounded-3xl p-8 w-full max-w-lg shadow-2xl transform scale-95 transition-transform" id="modalContent">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-black text-2xl text-slate-900 tracking-tight" id="modalTitle">Tambah Rak Baru</h3>
            <button onclick="closeModalRak()" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="<?= base_url('rak/store') ?>" method="POST">
            <!-- Input tersembunyi untuk menyimpan ID jika sedang Edit -->
            <input type="hidden" name="id_rak" id="id_rak">
            
            <div class="mb-5">
                <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Kode / Nama Rak</label>
                <input type="text" name="nama_rak" id="nama_rak" class="w-full border-2 border-slate-200 rounded-xl p-3.5 text-sm font-bold text-slate-800 focus:border-emerald-500 focus:ring-0 outline-none transition-colors" required placeholder="Contoh: RAK-A1">
            </div>
            
            <div class="mb-8">
                <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Detail Lokasi</label>
                <textarea name="lokasi" id="lokasi" class="w-full border-2 border-slate-200 rounded-xl p-3.5 text-sm font-medium text-slate-700 focus:border-emerald-500 focus:ring-0 outline-none transition-colors" rows="3" placeholder="Contoh: Lantai 1 Sayap Timur"></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeModalRak()" class="flex-1 py-3.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                <button type="submit" class="flex-1 py-3.5 bg-emerald-500 text-white font-black rounded-xl hover:bg-emerald-600 shadow-lg shadow-emerald-500/30 transition-all">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk membuka modal tambah data
    function openModalRak() {
        document.getElementById('modalTitle').innerText = 'Tambah Rak Baru';
        document.getElementById('id_rak').value = '';
        document.getElementById('nama_rak').value = '';
        document.getElementById('lokasi').value = '';
        
        const modal = document.getElementById('modalRak');
        modal.classList.remove('hidden');
        setTimeout(() => document.getElementById('modalContent').classList.remove('scale-95'), 10);
    }

    // Fungsi untuk membuka modal saat tombol edit ditekan
    function editRak(id, nama, lokasi) {
        document.getElementById('modalTitle').innerText = 'Edit Data Rak';
        document.getElementById('id_rak').value = id;
        document.getElementById('nama_rak').value = nama;
        document.getElementById('lokasi').value = lokasi;
        
        const modal = document.getElementById('modalRak');
        modal.classList.remove('hidden');
        setTimeout(() => document.getElementById('modalContent').classList.remove('scale-95'), 10);
    }

    // Fungsi menutup modal
    function closeModalRak() {
        document.getElementById('modalContent').classList.add('scale-95');
        setTimeout(() => document.getElementById('modalRak').classList.add('hidden'), 150);
    }
</script>

<?= $this->endSection() ?>