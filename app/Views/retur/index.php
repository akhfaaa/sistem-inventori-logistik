<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="p-8">
    <div class="mb-10">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Reverse Logistics</h2>
        <p class="text-slate-500 mt-1.5 text-sm font-medium">Manajemen pengembalian barang dan penyesuaian stok anomali gudang.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 h-fit">
            <div class="flex items-center gap-3 mb-8 pb-6 border-b border-slate-50">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                </div>
                <h2 class="text-lg font-bold text-slate-900">Return Execution</h2>
            </div>

            <form action="<?= base_url('retur/store') ?>" method="POST" class="space-y-6">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Item to Return</label>
                    <select name="id_barang" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-semibold outline-none focus:ring-2 focus:ring-amber-100 focus:bg-white transition-all">
                        <option value="">-- Pilih Barang --</option>
                        <?php foreach($barang as $b): ?>
                            <option value="<?= $b['id_barang'] ?>">[<?= $b['kode_barang'] ?>] <?= $b['nama_barang'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Quantity</label>
                        <input type="number" name="qty_retur" min="1" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Stock Action</label>
                        <select name="aksi_stok" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-amber-600 outline-none">
                            <option value="Kembali ke Stok">♻️ Re-stock</option>
                            <option value="Musnahkan">🗑️ Scrapped</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Reason of Return</label>
                    <textarea name="alasan" required rows="3" placeholder="Contoh: Barang cacat produksi / Salah kirim ukuran" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none"></textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-amber-500 text-white py-4 rounded-2xl text-sm font-bold shadow-lg shadow-amber-100 hover:bg-amber-600 active:scale-95 transition-all flex justify-center items-center gap-2">
                        Execute Adjustment
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                <h2 class="font-bold text-slate-800">Return Logs & Anomaly Records</h2>
                <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-md uppercase tracking-wider border border-amber-100">Live Audit</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-bold border-b border-slate-50">
                            <th class="px-8 py-5">Date</th>
                            <th class="px-8 py-5">Product & Reason</th>
                            <th class="px-8 py-5 text-center">Action</th>
                            <th class="px-8 py-5 text-right">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php foreach($riwayat as $r): ?>
                            <tr class="group hover:bg-slate-50/80 transition-all">
                                <td class="px-8 py-5">
                                    <span class="text-sm font-semibold text-slate-600 block"><?= date('d M Y', strtotime($r['tanggal_retur'])) ?></span>
                                    <span class="text-[10px] font-bold text-slate-400"><?= date('H:i', strtotime($r['tanggal_retur'])) ?> WIB</span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-sm font-bold text-slate-800 block"><?= $r['nama_barang'] ?></span>
                                    <p class="text-[11px] text-slate-500 italic mt-0.5"><?= $r['alasan'] ?></p>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <?php if($r['aksi_stok'] == 'Kembali ke Stok'): ?>
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold rounded-lg border border-emerald-100 uppercase">Re-stock</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-rose-50 text-rose-600 text-[10px] font-bold rounded-lg border border-rose-100 uppercase">Scrapped</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-8 py-5 text-right font-black text-slate-700">
                                    <?= $r['qty_retur'] ?> unit
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if(empty($riwayat)): ?>
                            <tr><td colspan="4" class="px-8 py-16 text-center text-slate-400 italic text-sm">No return activities found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>