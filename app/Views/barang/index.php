<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="p-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-black rounded uppercase tracking-tighter">Inventory Control</span>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Katalog Master Aset</h1>
            <p class="text-slate-500 text-sm font-medium mt-1">Kelola dan pantau seluruh barang persediaan secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="px-5 py-2.5 bg-slate-900 text-amber-400 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-800 shadow-lg shadow-slate-200 flex items-center gap-2 transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                Tambah Aset
            </button>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg flex items-start gap-3">
            <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-bold text-emerald-800"><?= session()->getFlashdata('success') ?></p>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
        
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row gap-4 items-center justify-between">
            
            <div class="relative w-full sm:w-96 group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400 group-focus-within:text-amber-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="liveSearch" placeholder="Cari nama atau kode ID aset..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none transition-all shadow-sm">
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest hidden sm:block">Filter:</span>
                <select id="categoryFilter" class="w-full sm:w-56 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-amber-400 outline-none cursor-pointer shadow-sm transition-all">
                    <option value="ALL">Semua Kategori</option>
                    <?php foreach($kategori ?? [] as $k): ?>
                        <option value="<?= $k['nama_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="dataTable">
                <thead>
                    <tr class="bg-white border-b border-slate-100">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kode & Nama Barang</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kategori & Rak</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Stok Aktual</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Harga Beli</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(empty($barang ?? [])): ?>
                        <tr id="defaultEmptyRow">
                            <td colspan="5" class="px-6 py-10 text-center text-sm font-bold text-slate-400">Sistem belum memiliki data master barang.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($barang ?? [] as $b) : ?>
                            <tr class="asset-row hover:bg-slate-50/50 transition-colors group" 
                                data-nama="<?= strtolower($b['nama_barang']) ?>" 
                                data-kode="<?= strtolower($b['kode_barang']) ?>" 
                                data-kategori="<?= $b['nama_kategori'] ?? 'Tanpa Kategori' ?>">
                                
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 font-black text-xs uppercase group-hover:bg-amber-100 group-hover:text-amber-700 transition-colors">
                                            <?= substr($b['nama_barang'], 0, 3) ?>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800"><?= $b['nama_barang'] ?></p>
                                            <p class="text-[10px] font-medium text-slate-400 uppercase mt-0.5 tracking-tighter">ID: <?= $b['kode_barang'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-full border border-slate-200"><?= $b['nama_kategori'] ?? 'Tanpa Kategori' ?></span>
                                    <p class="text-[10px] font-bold text-slate-400 mt-2 ml-1">📍 Rak: <?= $b['nama_rak'] ?? 'Belum Dialokasikan' ?></p>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-black text-slate-900"><?= $b['stok_aktual'] ?></span>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase">Unit</span>
                                        </div>
                                        <?php if($b['stok_aktual'] <= $b['stok_minimum']): ?>
                                            <span class="text-[9px] font-bold text-rose-500 uppercase tracking-wider">Stok Kritis!</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-sm font-bold text-slate-700">Rp <?= number_format($b['harga_beli'], 0, ',', '.') ?></span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button onclick="document.getElementById('modalEdit<?= $b['id_barang'] ?>').classList.remove('hidden')" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <a href="<?= base_url('barang/delete/' . $b['id_barang']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus aset <?= $b['nama_barang'] ?>?');" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <tr id="noResultRow" style="display: none;">
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <p class="text-sm font-bold text-slate-500">Aset yang Anda cari tidak ditemukan.</p>
                                <p class="text-[11px] font-medium text-slate-400 mt-1">Coba gunakan kata kunci lain atau periksa filter kategori Anda.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalTambah" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl p-8 transform transition-all">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-extrabold text-slate-900">Registrasi Aset Baru</h2>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-slate-400 hover:text-rose-500 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="<?= base_url('barang/store') ?>" method="POST" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">Kode Barang</label>
                    <input type="text" name="kode_barang" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">Nama Barang</label>
                    <input type="text" name="nama_barang" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 outline-none">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">Kategori</label>
                    <select name="id_kategori" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 outline-none">
                        <option value="">Pilih Kategori...</option>
                        <?php foreach($kategori ?? [] as $k): ?>
                            <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">Penempatan Rak</label>
                    <select name="id_rak" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 outline-none">
                        <option value="">-- Kosongkan Jika Belum Ada --</option>
                        <?php foreach($rak ?? [] as $r): ?>
                            <option value="<?= $r['id_rak'] ?>"><?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">Stok Aktual</label>
                    <input type="number" name="stok_aktual" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">Batas Kritis</label>
                    <input type="number" name="stok_minimum" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">Harga Beli</label>
                    <input type="number" name="harga_beli" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 outline-none">
                </div>
            </div>
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100 mt-6">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-5 py-3 text-sm font-bold text-slate-500 hover:bg-slate-50 rounded-xl transition-all">Batal</button>
                <button type="submit" class="px-5 py-3 bg-slate-900 text-amber-400 text-sm font-bold rounded-xl hover:bg-slate-800 transition-all shadow-lg">Simpan Aset</button>
            </div>
        </form>
    </div>
</div>

<?php if(!empty($barang ?? [])): ?>
    <?php foreach ($barang ?? [] as $b) : ?>
    <div id="modalEdit<?= $b['id_barang'] ?>" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl p-8 transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-extrabold text-slate-900">Edit Data Aset</h2>
                <button onclick="document.getElementById('modalEdit<?= $b['id_barang'] ?>').classList.add('hidden')" class="text-slate-400 hover:text-rose-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="<?= base_url('barang/update/' . $b['id_barang']) ?>" method="POST" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">Kode Barang</label>
                        <input type="text" name="kode_barang" value="<?= $b['kode_barang'] ?>" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">Nama Barang</label>
                        <input type="text" name="nama_barang" value="<?= $b['nama_barang'] ?>" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">Kategori</label>
                        <select name="id_kategori" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 outline-none">
                            <?php foreach($kategori ?? [] as $k): ?>
                                <option value="<?= $k['id_kategori'] ?>" <?= ($b['id_kategori'] == $k['id_kategori']) ? 'selected' : '' ?>><?= $k['nama_kategori'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">Penempatan Rak</label>
                        <select name="id_rak" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 outline-none">
                            <option value="">-- Kosongkan Jika Belum Ada --</option>
                            <?php foreach($rak ?? [] as $r): ?>
                                <option value="<?= $r['id_rak'] ?>" <?= ($b['id_rak'] == $r['id_rak']) ? 'selected' : '' ?>><?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">Stok Aktual</label>
                        <input type="number" name="stok_aktual" value="<?= $b['stok_aktual'] ?>" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">Batas Kritis</label>
                        <input type="number" name="stok_minimum" value="<?= $b['stok_minimum'] ?>" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2">Harga Beli</label>
                        <input type="number" name="harga_beli" value="<?= $b['harga_beli'] ?>" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-amber-400 outline-none">
                    </div>
                </div>
                <div class="pt-4 flex justify-end gap-3 border-t border-slate-100 mt-6">
                    <button type="button" onclick="document.getElementById('modalEdit<?= $b['id_barang'] ?>').classList.add('hidden')" class="px-5 py-3 text-sm font-bold text-slate-500 hover:bg-slate-50 rounded-xl transition-all">Batal</button>
                    <button type="submit" class="px-5 py-3 bg-slate-900 text-amber-400 text-sm font-bold rounded-xl hover:bg-slate-800 transition-all shadow-lg">Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('liveSearch');
    const categoryFilter = document.getElementById('categoryFilter');
    const assetRows = document.querySelectorAll('.asset-row');
    const noResultRow = document.getElementById('noResultRow');

    function applyFilters() {
        const keyword = searchInput.value.toLowerCase().trim();
        const selectedCategory = categoryFilter.value;
        let visibleCount = 0;

        assetRows.forEach(row => {
            const namaBarang = row.getAttribute('data-nama');
            const kodeBarang = row.getAttribute('data-kode');
            const kategoriBarang = row.getAttribute('data-kategori');

            // Cek kecocokan pencarian (Nama atau Kode)
            const matchSearch = namaBarang.includes(keyword) || kodeBarang.includes(keyword);
            // Cek kecocokan kategori (Kategori sama, atau jika memilih "ALL")
            const matchCategory = selectedCategory === 'ALL' || kategoriBarang === selectedCategory;

            // Jika baris cocok dengan kedua filter, tampilkan
            if (matchSearch && matchCategory) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Tampilkan ilustrasi "Tidak ada hasil" jika tidak ada baris yang cocok
        if (noResultRow) {
            noResultRow.style.display = (visibleCount === 0) ? '' : 'none';
        }
    }

    // Jalankan filter setiap kali user mengetik atau mengubah dropdown
    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (categoryFilter) categoryFilter.addEventListener('change', applyFilters);
});
</script>

<?= $this->endSection() ?>