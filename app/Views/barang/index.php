<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-clinical-900">Master Barang</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola data inventaris, SKU, dan batas stok gudang.</p>
    </div>

    <button onclick="toggleModal()" class="bg-clinical-900 hover:bg-clinical-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah SKU Baru
    </button>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="p-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
        <div class="relative w-64">
            <input type="text" placeholder="Cari Kode atau Nama Barang..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-clinical-800 focus:ring-1 focus:ring-clinical-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <button class="text-gray-500 hover:text-clinical-900 text-sm font-medium flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            Filter
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white text-xs text-gray-500 uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4 font-semibold">Kode SKU</th>
                    <th class="px-6 py-4 font-semibold">Nama Barang</th>
                    <th class="px-6 py-4 font-semibold">Kategori</th>
                    <th class="px-6 py-4 text-right font-semibold">Harga Beli</th>
                    <th class="px-6 py-4 text-center font-semibold">Stok</th>
                    <th class="px-6 py-4 text-center font-semibold border-l border-gray-100">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if (empty($barang)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-sm font-medium text-gray-500">Belum ada data barang.</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($barang as $b): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-mono text-clinical-900"><?= $b['kode_barang'] ?></td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800"><?= $b['nama_barang'] ?></td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                    <?= $b['nama_kategori'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-right text-gray-600">Rp <?= number_format($b['harga_beli'], 0, ',', '.') ?></td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-bold <?= ($b['stok_aktual'] <= $b['batas_stok_kritis']) ? 'text-red-500' : 'text-clinical-900' ?>">
                                    <?= $b['stok_aktual'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center border-l border-gray-50">
                                <div class="flex justify-center gap-2">
                                    <button class="p-1.5 text-gray-400 hover:text-clinical-900 transition" title="Edit SKU">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-gray-400 hover:text-red-500 transition" title="Hapus SKU">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div id="modalTambahBarang" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-clinical-900">Formulir SKU Baru</h3>
            <button onclick="toggleModal()" class="text-gray-400 hover:text-red-500 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="<?= base_url('barang/store') ?>" method="POST" class="p-6">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode SKU</label>
                    <input type="text" name="kode_barang" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-clinical-800">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                    <input type="text" name="nama_barang" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-clinical-800">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Taksonomi</label>
                    <select name="id_kategori" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-clinical-800 bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategori as $k): ?>
                            <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Beli (Rp)</label>
                    <input type="number" name="harga_beli" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-clinical-800">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Awal</label>
                        <input type="number" name="stok_aktual" value="0" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-clinical-800">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Batas Kritis</label>
                        <input type="number" name="batas_stok_kritis" value="10" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-clinical-800">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="toggleModal()" class="px-5 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-clinical-900 rounded-lg hover:bg-clinical-800">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal() {
        const modal = document.getElementById('modalTambahBarang');
        modal.classList.toggle('hidden');
    }
</script>
<?= $this->endSection() ?>