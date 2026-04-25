<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-[1400px] mx-auto px-4 py-8">
    
    <div class="mb-10">
        <div class="inline-flex items-center px-3 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-full border border-indigo-100 mb-3 uppercase tracking-widest">
            Hak Akses: Kepala Balai Bapekom VII
        </div>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight flex items-center gap-3">
            Executive Summary
        </h1>
        <p class="text-slate-500 text-sm mt-2 font-medium max-w-2xl">
            Ringkasan strategis valuasi aset logistik dan tingkat efisiensi perputaran barang berbasis kecerdasan buatan SILABAK.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        
        <div class="md:col-span-8 bg-slate-900 text-white p-10 rounded-[2.5rem] shadow-2xl relative overflow-hidden flex flex-col justify-between group">
            <div class="relative z-10">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Valuasi Aset Gudang</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-bold text-emerald-400">Rp</span>
                    <span class="text-6xl font-black tracking-tighter">
                        <?= number_format($total_nilai, 0, ',', '.') ?>
                    </span>
                </div>
            </div>
            
            <div class="mt-12 grid grid-cols-2 gap-6 border-t border-white/10 pt-8 relative z-10">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-widest opacity-50 block mb-1">Status Keuangan</span>
                    <span class="text-sm font-bold text-emerald-400 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Sehat (Aman)
                    </span>
                </div>
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-widest opacity-50 block mb-1">Update Terakhir</span>
                    <span class="text-sm font-bold"><?= date('d F Y') ?></span>
                </div>
            </div>

            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl transition-transform duration-700 group-hover:scale-110"></div>
        </div>

        <div class="md:col-span-4 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6">Efisiensi Rotasi (AI)</h3>
                
                <div class="space-y-5">
                    <?php 
                    $colors = [
                        'Fast Moving' => 'text-emerald-600 bg-emerald-50',
                        'Slow Moving' => 'text-amber-600 bg-amber-50',
                        'Dead Stock'  => 'text-rose-600 bg-rose-50'
                    ];
                    foreach($rekap_kmeans as $r): 
                        $theme = $colors[$r['label_klaster']] ?? 'text-slate-600 bg-slate-50';
                    ?>
                    <div class="flex items-center justify-between p-3 rounded-xl <?= $theme ?>">
                        <span class="text-xs font-bold uppercase tracking-wider"><?= $r['label_klaster'] ?></span>
                        <span class="text-xl font-black"><?= $r['total'] ?> <span class="text-[10px] opacity-70">SKU</span></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <a href="<?= base_url('analitik') ?>" class="mt-8 text-center block w-full py-3 rounded-xl border-2 border-slate-100 text-xs font-bold text-slate-500 hover:bg-slate-50 hover:text-slate-800 transition-colors">
                Lihat Peta Spasial Penuh &rarr;
            </a>
        </div>

        <div class="md:col-span-12 bg-indigo-600 p-8 rounded-[2rem] shadow-xl text-white flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-sm font-black uppercase tracking-widest mb-1">Catatan Sistem</h4>
                    <p class="text-indigo-100 text-sm font-medium">Algoritma mendeteksi tumpukan Dead Stock. Disarankan untuk meninjau ulang kebijakan pengadaan barang kategori ini pada kuartal berikutnya.</p>
                </div>
            </div>
            <button class="px-6 py-3 bg-white text-indigo-600 text-xs font-black uppercase tracking-widest rounded-xl hover:shadow-lg transition-all shrink-0">
                Cetak Laporan
            </button>
        </div>

    </div>
</div>

<?= $this->endSection() ?>