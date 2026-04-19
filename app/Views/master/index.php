<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="p-8">
    <div class="mb-10">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Warehouse Taxonomy</h2>
        <p class="text-slate-500 mt-1.5 text-sm font-medium">Kelola klasifikasi produk dan pemetaan lokasi rak penyimpanan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        
        <div class="space-y-6">
            <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <span class="w-2 h-6 bg-indigo-500 rounded-full"></span>
                    Product Categories
                </h3>
                <form action="<?= base_url('master/storeKategori') ?>" method="POST" class="flex gap-2 mb-8">
                    <input type="text" name="nama_kategori" placeholder="Nama Kategori Baru..." required class="flex-1 px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none focus:ring-2 focus:ring-indigo-100">
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all">Add</button>
                </form>
                <div class="space-y-2">
                    <?php foreach($kategori as $k): ?>
                        <div class="flex justify-between items-center p-4 bg-slate-50/50 rounded-2xl border border-slate-100 group hover:border-indigo-200 transition-all">
                            <span class="text-sm font-semibold text-slate-700"><?= $k['nama_kategori'] ?></span>
                            <a href="<?= base_url('master/deleteKategori/'.$k['id_kategori']) ?>" class="opacity-0 group-hover:opacity-100 p-2 text-slate-400 hover:text-rose-500 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0_0,0.04)] border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <span class="w-2 h-6 bg-emerald-500 rounded-full"></span>
                    Warehouse Racks
                </h3>
                <form action="<?= base_url('master/storeRak') ?>" method="POST" class="space-y-3 mb-8 p-4 bg-slate-50 rounded-2xl">
                    <input type="text" name="nama_rak" placeholder="ID Rak (Contoh: RAK-A1)" required class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-sm outline-none">
                    <input type="text" name="lokasi" placeholder="Lokasi Spesifik..." required class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-sm outline-none">
                    <button type="submit" class="w-full py-3 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition-all">Register Rack</button>
                </form>
                <div class="space-y-2">
                    <?php foreach($rak as $r): ?>
                        <div class="flex justify-between items-center p-4 bg-slate-50/50 rounded-2xl border border-slate-100 group hover:border-emerald-200 transition-all">
                            <div>
                                <span class="text-sm font-bold text-slate-800 block"><?= $r['nama_rak'] ?></span>
                                <span class="text-[10px] text-slate-400 font-medium uppercase tracking-wider"><?= $r['lokasi'] ?></span>
                            </div>
                            <a href="<?= base_url('master/deleteRak/'.$r['id_rak']) ?>" class="opacity-0 group-hover:opacity-100 p-2 text-slate-400 hover:text-rose-500 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>