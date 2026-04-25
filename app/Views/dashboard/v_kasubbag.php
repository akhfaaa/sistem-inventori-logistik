<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-[1400px] mx-auto px-4 py-8">
    
    <div class="mb-10 flex justify-between items-end">
        <div>
            <div class="inline-flex items-center px-3 py-1 bg-amber-50 text-amber-700 text-[10px] font-black rounded-full border border-amber-100 mb-3 uppercase tracking-widest">
                Managerial Control: Kasubbag Umum & TU
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Operational Monitor</h1>
            <p class="text-slate-500 text-sm mt-2 font-medium">Pantau ketersediaan stok kritis dan validasi aktivitas logistik secara real-time.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        
        <div class="md:col-span-7 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col group">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-6 bg-rose-500 rounded-full"></span>
                    Inventory Alert Center
                </h3>
                <span class="px-3 py-1 bg-rose-50 text-rose-600 text-[10px] font-black rounded-lg"><?= count($stok_kritis) ?> Barang Kritis</span>
            </div>
            
            <div class="flex-1 overflow-y-auto max-h-[300px] pr-2 space-y-3">
                <?php if(empty($stok_kritis)): ?>
                    <div class="py-10 text-center text-slate-400 text-xs font-bold italic">Seluruh stok dalam kondisi aman.</div>
                <?php else: foreach($stok_kritis as $s): ?>
                    <div class="flex justify-between items-center p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-rose-200 transition-colors">
                        <div>
                            <p class="text-xs font-black text-slate-800 uppercase"><?= $s['nama_barang'] ?></p>
                            <p class="text-[10px] text-slate-500 font-bold uppercase">Min: <?= $s['stok_minimum'] ?> | Sisa: <span class="text-rose-600"><?= $s['stok_aktual'] ?></span></p>
                        </div>
                        <a href="<?= base_url('inbound') ?>" class="p-2 bg-white rounded-xl shadow-sm text-rose-500 hover:bg-rose-500 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        </a>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>

        <div class="md:col-span-5 bg-indigo-600 p-8 rounded-[2.5rem] text-white shadow-2xl shadow-indigo-100 flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-black uppercase tracking-widest mb-8 opacity-60">Volume Transaksi Hari Ini</h3>
                <p class="text-7xl font-black tracking-tighter mb-2"><?= $outbound_today ?></p>
                <p class="text-sm font-bold opacity-80 uppercase tracking-widest">Barang Keluar (Outbound)</p>
            </div>
            <div class="pt-6 border-t border-white/10">
                <p class="text-[10px] font-medium leading-relaxed opacity-70 italic italic">"Pastikan setiap mutasi barang keluar telah diverifikasi dengan surat jalan yang valid."</p>
            </div>
        </div>

        <div class="md:col-span-12 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-8">Jejak Aktivitas Staf Gudang</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <?php foreach($recent_logs as $log): ?>
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <span class="text-[9px] font-black text-indigo-500 uppercase block mb-1"><?= date('H:i', strtotime($log['waktu'])) ?></span>
                    <p class="text-[11px] font-bold text-slate-700 leading-tight mb-2"><?= $log['aktivitas'] ?></p>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter italic">Oleh: <?= $log['nama_lengkap'] ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>