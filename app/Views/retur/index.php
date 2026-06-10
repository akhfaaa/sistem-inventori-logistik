<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php $barang = $barang ?? []; ?>
<?php $riwayat = $riwayat ?? []; ?>

<div class="p-8">
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-0.5 bg-violet-100 text-violet-700 text-[10px] font-black rounded uppercase tracking-tighter">Reverse Logistics</span>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Retur Aset</h2>
            <p class="text-slate-500 mt-1.5 text-sm font-medium">Pencatatan pengembalian barang atas alasan cacat fisik atau kesalahan distribusi.</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-8 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg flex items-start gap-3">
            <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-bold text-emerald-800"><?= session()->getFlashdata('success') ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 h-fit">
            <div class="flex items-center gap-3 mb-8 pb-6 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                </div>
                <h2 class="text-lg font-bold text-slate-900">Form Pengembalian</h2>
            </div>

            <form action="<?= base_url('retur/store') ?>" method="POST" class="space-y-5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Aset / Barang Terkait</label>
                    <select name="id_barang" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:bg-white focus:ring-2 focus:ring-violet-400 outline-none transition-all">
                        <option value="">-- Pilih Barang --</option>
                        <?php foreach($barang as $b): ?>
                            <option value="<?= $b['id_barang'] ?>">
                                [<?= $b['kode_barang'] ?>] - <?= $b['nama_barang'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Volume Retur</label>
                    <input type="number" name="qty_retur" min="1" required placeholder="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:bg-white focus:ring-2 focus:ring-violet-400 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Kondisi & Tindakan</label>
                    <select name="aksi_stok" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:bg-white focus:ring-2 focus:ring-violet-400 outline-none transition-all">
                        <option value="">-- Pilih Tindakan Sistem --</option>
                        <option value="Kembali ke Stok">📦 Layak Pakai - Kembalikan ke Stok</option>
                        <option value="Musnahkan">🔥 Rusak/Cacat - Musnahkan Aset</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Alasan Retur</label>
                    <textarea name="alasan" rows="3" required placeholder="Jelaskan alasan pengembalian..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:bg-white focus:ring-2 focus:ring-violet-400 outline-none transition-all resize-none"></textarea>
                </div>
                
                <div class="pt-4 border-t border-slate-100">
                    <button type="submit" class="w-full bg-slate-900 text-violet-300 py-3.5 rounded-xl text-sm font-bold tracking-wide hover:bg-slate-800 hover:text-violet-200 transition-all shadow-lg flex justify-center items-center gap-2">
                        Proses Retur & Audit
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h2 class="font-bold text-slate-800">Buku Register Retur</h2>
            </div>
            
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-black border-b border-slate-100 bg-white">
                            <th class="px-6 py-5">Tanggal</th>
                            <th class="px-6 py-5">Informasi Barang</th>
                            <th class="px-6 py-5">Keterangan</th>
                            <th class="px-6 py-5 text-right">Volume</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if(empty($riwayat)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm font-medium text-slate-400">Belum ada aktivitas retur yang tercatat.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($riwayat as $r): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 align-top">
                                        <span class="text-sm font-bold text-slate-700 block"><?= date('d M Y', strtotime($r['tanggal_retur'])) ?></span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter"><?= date('H:i', strtotime($r['tanggal_retur'])) ?> WIB</span>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <span class="text-sm font-bold text-slate-900 block"><?= $r['nama_barang'] ?></span>
                                        <span class="text-[10px] font-bold text-slate-400">ID: <?= $r['kode_barang'] ?></span>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <p class="text-xs font-medium text-slate-600 mb-2 leading-relaxed">"<?= $r['alasan'] ?>"</p>
                                        
                                        <?php if($r['aksi_stok'] == 'Kembali ke Stok'): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-widest border border-emerald-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Dikembalikan ke Stok
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-rose-50 text-rose-600 text-[9px] font-black uppercase tracking-widest border border-rose-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Dimusnahkan
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 align-top text-right">
                                        <span class="inline-flex items-center gap-1.5 text-sm font-black text-violet-600 bg-violet-50 px-3 py-1 rounded-lg border border-violet-100">
                                            <?= $r['qty_retur'] ?> Unit
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>