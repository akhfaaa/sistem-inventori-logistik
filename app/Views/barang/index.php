<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div class="w-full md:w-1/2">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Master Barang</h2>
            <p class="text-slate-500 mt-1.5 text-sm font-medium">Kelola SKU, taksonomi kategori, dan lokasi rak penyimpanan.</p>
        </div>
        <div class="w-full md:w-1/2 flex justify-end">
            <button onclick="toggleModal()" class="bg-indigo-600 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Add New SKU
            </button>
        </div>
    </div>

    <div class="mb-6 relative w-full max-w-md">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search by SKU code or item name..." class="w-full pl-11 pr-4 py-3 bg-white border border-slate-100 rounded-xl text-sm outline-none focus:ring-2 focus:ring-indigo-100 shadow-sm transition-all">
    </div>

    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="dataTable">
                <thead>
                    <tr class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-bold border-b border-slate-50 bg-slate-50/30">
                        <th class="px-8 py-5">SKU Code</th>
                        <th class="px-8 py-5">Product Identity</th>
                        <th class="px-8 py-5 text-center">Category</th>
                        <th class="px-8 py-5 text-center">Warehouse Rack</th>
                        <th class="px-8 py-5">Unit Price</th>
                        <th class="px-8 py-5 text-center">Stock</th>
                        <th class="px-8 py-5 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach ($barang as $b): ?>
                    <tr class="group hover:bg-slate-50/80 transition-all">
                        <td class="px-8 py-5">
                            <span class="text-sm font-bold text-indigo-600"><?= $b['kode_barang'] ?></span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-bold text-slate-800"><?= $b['nama_barang'] ?></span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[10px] font-bold rounded-lg uppercase border border-slate-200">
                                <?= $b['nama_kategori'] ?? 'N/A' ?>
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold rounded-lg uppercase border border-emerald-100">
                                <?= $b['nama_rak'] ?? 'No Rack' ?>
                            </span>
                        </td>
                        <td class="px-8 py-5 text-sm text-slate-600 font-medium">
                            Rp <?= number_format($b['harga_beli'], 0, ',', '.') ?>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="text-sm font-black text-slate-900"><?= $b['stok_aktual'] ?></span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="openEditSku(<?= $b['id_barang'] ?>, '<?= $b['kode_barang'] ?>', '<?= htmlspecialchars($b['nama_barang'], ENT_QUOTES) ?>', '<?= $b['id_kategori'] ?>', '<?= $b['id_rak'] ?>', <?= $b['stok_aktual'] ?>, <?= $b['stok_minimum'] ?>, <?= $b['harga_beli'] ?>)" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all" title="Edit Item">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <a href="<?= base_url('barang/delete/' . $b['id_barang']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus SKU ini secara permanen?')" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all" title="Delete SKU">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalAddSku" class="fixed inset-0 z-[100] hidden bg-slate-900/40 backdrop-blur-md flex items-center justify-center p-4 transition-all">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <h3 class="text-xl font-extrabold text-slate-900">Register New SKU</h3>
            <button onclick="toggleModal()" class="p-2 hover:bg-rose-50 text-slate-400 hover:text-rose-500 rounded-xl transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="<?= base_url('barang/store') ?>" method="POST" class="p-8 space-y-5">
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Item Code (SKU)</label>
                    <input type="text" name="kode_barang" required placeholder="Contoh: BRG-001" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none focus:ring-2 focus:ring-indigo-100">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Product Name</label>
                    <input type="text" name="nama_barang" required placeholder="Nama barang lengkap" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Category</label>
                    <select name="id_kategori" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-100">
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach($kategori as $k): ?>
                            <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Warehouse Rack</label>
                    <select name="id_rak" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-100">
                        <option value="">-- Pilih Lokasi Rak --</option>
                        <?php foreach($rak as $r): ?>
                            <option value="<?= $r['id_rak'] ?>"><?= $r['nama_rak'] ?> (<?= $r['lokasi'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Initial Stock</label>
                    <input type="number" name="stok_aktual" required placeholder="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Safety Stock</label>
                    <input type="number" name="stok_minimum" required placeholder="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Price (HPP)</label>
                    <input type="number" name="harga_beli" required placeholder="Rp 0" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end gap-3">
                <button type="button" onclick="toggleModal()" class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 transition-all">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-10 py-3 rounded-xl text-sm font-bold shadow-lg shadow-indigo-100 active:scale-95 transition-all">Save New SKU</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditSku" class="fixed inset-0 z-[100] hidden bg-slate-900/40 backdrop-blur-md flex items-center justify-center p-4 transition-all">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="text-xl font-extrabold text-slate-900">Update SKU Data</h3>
                <p id="edit_sku_label" class="text-xs text-indigo-600 font-bold uppercase tracking-widest mt-1"></p>
            </div>
            <button onclick="closeEditSku()" class="p-2 hover:bg-rose-50 text-slate-400 hover:text-rose-500 rounded-xl transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="<?= base_url('barang/update') ?>" method="POST" class="p-8 space-y-5">
            <input type="hidden" name="id_barang" id="edit_id_barang">
            
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Item Code (SKU)</label>
                    <input type="text" name="kode_barang" id="edit_kode" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none focus:ring-2 focus:ring-indigo-100">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Product Name</label>
                    <input type="text" name="nama_barang" id="edit_nama" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Category</label>
                    <select name="id_kategori" id="edit_kategori" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-semibold outline-none">
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach($kategori as $k): ?>
                            <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Warehouse Rack</label>
                    <select name="id_rak" id="edit_rak" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-semibold outline-none">
                        <option value="">-- Pilih Lokasi Rak --</option>
                        <?php foreach($rak as $r): ?>
                            <option value="<?= $r['id_rak'] ?>"><?= $r['nama_rak'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Stock</label>
                    <input type="number" name="stok_aktual" id="edit_stok" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Safety Stock</label>
                    <input type="number" name="batas_stok_kritis" id="edit_kritis" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Price (HPP)</label>
                    <input type="number" name="harga_beli" id="edit_harga" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end gap-3">
                <button type="button" onclick="closeEditSku()" class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 transition-all">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-10 py-3 rounded-xl text-sm font-bold shadow-lg shadow-indigo-100 active:scale-95 transition-all">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk membuka Modal Tambah
    function toggleModal() {
        document.getElementById('modalAddSku').classList.toggle('hidden');
    }

    // Fungsi untuk membuka Modal Edit dan memuat data otomatis
    function openEditSku(id, kode, nama, kat, rak, stok, kritis, harga) {
        document.getElementById('edit_id_barang').value = id;
        document.getElementById('edit_kode').value = kode;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_kategori').value = kat;
        document.getElementById('edit_rak').value = rak;
        document.getElementById('edit_stok').value = stok;
        document.getElementById('edit_kritis').value = kritis;
        document.getElementById('edit_harga').value = harga;
        
        document.getElementById('edit_sku_label').innerText = "Editing: " + kode;
        document.getElementById('modalEditSku').classList.remove('hidden');
    }

    // Fungsi untuk menutup Modal Edit
    function closeEditSku() {
        document.getElementById('modalEditSku').classList.add('hidden');
    }

    // Fungsi Pencarian / Filter Tabel Live
    function filterTable() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let rows = document.querySelectorAll("#dataTable tbody tr");

        rows.forEach(row => {
            // Mencocokkan teks pada kolom SKU (sel ke-0) dan Nama Barang (sel ke-1)
            let sku = row.cells[0].innerText.toLowerCase();
            let name = row.cells[1].innerText.toLowerCase();

            if (sku.includes(input) || name.includes(input)) {
                row.style.display = ""; // Tampilkan baris jika cocok
            } else {
                row.style.display = "none"; // Sembunyikan baris jika tidak cocok
            }
        });
    }
</script>

<?= $this->endSection() ?>