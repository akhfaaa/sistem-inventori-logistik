<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-[1400px] mx-auto px-4 py-8">
    
    <div class="mb-10">
        <div class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-black rounded-full border border-emerald-100 mb-3 uppercase tracking-widest">
            Akses Operasional: Staff Gudang
        </div>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Warehouse Operations</h1>
        <p class="text-slate-500 text-sm mt-2 font-medium">Pusat kendali mutasi harian dan pencatatan fisik logistik Bapekom VII.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        
        <div class="md:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="<?= base_url('inbound') ?>" class="group bg-indigo-600 p-8 rounded-[2.5rem] text-white shadow-xl hover:shadow-indigo-500/30 hover:-translate-y-1 transition-all flex flex-col justify-between relative overflow-hidden">
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mb-8 backdrop-blur-sm">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    </div>
                    <h3 class="text-3xl font-black tracking-tight mb-2">Barang<br/>Masuk</h3>
                    <p class="text-xs font-medium text-indigo-100 opacity-80">Catat penerimaan stok baru dari vendor atau pengadaan.</p>
                </div>
                <div class="absolute -right-10 -bottom-10 opacity-10 group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                </div>
            </a>

            <a href="<?= base_url('outbound') ?>" class="group bg-slate-900 p-8 rounded-[2.5rem] text-white shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all flex flex-col justify-between relative overflow-hidden">
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-8">
                        <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    </div>
                    <h3 class="text-3xl font-black tracking-tight mb-2">Barang<br/>Keluar</h3>
                    <p class="text-xs font-medium text-slate-400">Catat distribusi logistik untuk keperluan internal balai.</p>
                </div>
            </a>
        </div>

        <div class="md:col-span-4 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Aktivitas Hari Ini (<?= date('d M Y') ?>)</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-indigo-50 rounded-2xl border border-indigo-100">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                            <span class="text-xs font-black text-slate-700 uppercase tracking-widest">Inbound</span>
                        </div>
                        <span class="text-2xl font-black text-indigo-700"><?= $transaksi_masuk_hari_ini ?></span>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                            <span class="text-xs font-black text-slate-700 uppercase tracking-widest">Outbound</span>
                        </div>
                        <span class="text-2xl font-black text-emerald-700"><?= $transaksi_keluar_hari_ini ?></span>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 pt-6 border-t border-slate-100">
                <div class="flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    <span>Total SKU Tersimpan:</span>
                    <span class="text-slate-800 text-sm"><?= $total_barang ?> Jenis</span>
                </div>
            </div>
        </div>

        <div class="md:col-span-12 bg-white p-8 rounded-[2.5rem] border border-rose-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-6 bg-rose-500 rounded-full"></span>
                    Perhatian: Stok Fisik Menipis
                </h3>
            </div>
            
            <?php if(empty($stok_menipis)): ?>
                <div class="p-8 text-center bg-slate-50 rounded-2xl border border-slate-100 border-dashed">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Seluruh stok fisik saat ini dalam batas aman.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <?php foreach($stok_menipis as $sm): ?>
                    <div class="p-5 bg-rose-50/50 rounded-2xl border border-rose-100 hover:bg-rose-50 transition-colors">
                        <p class="text-xs font-black text-slate-800 uppercase mb-2 line-clamp-1" title="<?= $sm['nama_barang'] ?>"><?= $sm['nama_barang'] ?></p>
                        <div class="flex justify-between items-end">
                            <div>
                                <span class="text-[9px] font-bold text-slate-500 uppercase block mb-0.5">Sisa Fisik</span>
                                <span class="text-xl font-black text-rose-600"><?= $sm['stok_aktual'] ?></span>
                            </div>
                            <div class="text-right">
                                <span class="text-[9px] font-bold text-slate-500 uppercase block mb-0.5">Batas Min</span>
                                <span class="text-sm font-black text-slate-700"><?= $sm['stok_minimum'] ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?= $this->endSection() ?>