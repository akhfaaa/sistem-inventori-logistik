<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="p-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Master Barang</h2>
            <p class="text-slate-500 mt-1.5 text-sm font-medium">Kelola SKU, taksonomi kategori, dan parameter batas stok kritis.</p>
        </div>

        <button onclick="toggleModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-100 flex items-center gap-2 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add New SKU
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 bg-slate-50/30 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="relative w-full md:w-96">
                <input type="text" placeholder="Search by SKU code or item name..." class="w-full pl-11 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition-all">
                <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"></path></svg>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mr-2">Displaying: <?= count($barang) ?> Items</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-400 text-[11px] uppercase tracking-[0.15em] font-bold border-b border-slate-100">
                        <th class="px-8 py-5">SKU Code</th>
                        <th class="px-8 py-5">Product Identity</th>
                        <th class="px-8 py-5">Category</th>
                        <th class="px-8 py-5 text-right">Unit Price</th>
                        <th class="px-8 py-5 text-center">Stock</th>
                        <th class="px-8 py-5 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach ($barang as $b): ?>
                        <tr class="group hover:bg-slate-50/80 transition-all duration-200">
                            <td class="px-8 py-5 text-sm font-bold text-indigo-600 font-mono"><?= $b['kode_barang'] ?></td>
                            <td class="px-8 py-5">
                                <span class="text-sm font-semibold text-slate-800 block"><?= $b['nama_barang'] ?></span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-extrabold uppercase bg-slate-100 text-slate-500 border border-slate-200">
                                    <?= $b['nama_kategori'] ?>
                                </span>
                            </td>
                            <td class="px-8 py-5 text-sm text-right font-medium text-slate-600">Rp <?= number_format($b['harga_beli'], 0, ',', '.') ?></td>
                            <td class="px-8 py-5 text-center">
                                <?php $isKritis = $b['stok_aktual'] <= $b['batas_stok_kritis']; ?>
                                <span class="text-base font-extrabold <?= $isKritis ? 'text-rose-500' : 'text-slate-900' ?>">
                                    <?= $b['stok_aktual'] ?>
                                </span>
                                <?php if($isKritis): ?>
                                    <span class="block text-[9px] font-bold text-rose-400 uppercase tracking-tight">Requires Attention</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex justify-center items-center gap-1">
                                    <button class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Edit Product">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Delete Product">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalTambahBarang" class="fixed inset-0 z-[100] hidden bg-slate-900/40 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-xl overflow-hidden transform transition-all">
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="text-xl font-extrabold text-slate-900">New SKU Registration</h3>
                <p class="text-xs text-slate-500 font-medium">Lengkapi parameter inventori di bawah ini.</p>
            </div>
            <button onclick="toggleModal()" class="p-2 hover:bg-rose-50 text-slate-400 hover:text-rose-500 rounded-xl transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="<?= base_url('barang/store') ?>" method="POST" class="p-8">
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">SKU Code</label>
                        <input type="text" name="kode_barang" required placeholder="misal: BRG-001" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Item Name</label>
                        <input type="text" name="nama_barang" required placeholder="Nama Produk" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Inventory Category</label>
                    <select name="id_kategori" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all appearance-none cursor-pointer">
                        <option value="">Select Category...</option>
                        <?php foreach ($kategori as $k): ?>
                            <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-1">
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Initial Qty</label>
                        <input type="number" name="stok_aktual" value="0" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Critical Cap</label>
                        <input type="number" name="batas_stok_kritis" value="10" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Unit Price</label>
                        <input type="number" name="harga_beli" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-10 pt-6 border-t border-slate-50">
                <button type="button" onclick="toggleModal()" class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">Cancel</button>
                <button type="submit" class="px-8 py-3 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 active:scale-95 transition-all">Confirm & Save</button>
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