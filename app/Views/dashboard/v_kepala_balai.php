<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-[1400px] mx-auto px-6 py-8">
    
    <div class="mb-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-amber-100 rounded-full blur-3xl opacity-50"></div>
        
        <div class="relative z-10">
            <div class="inline-flex items-center px-3 py-1 bg-slate-900 text-amber-400 text-[10px] font-black rounded-lg border border-slate-700 mb-4 uppercase tracking-widest">
                Executive Overview
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Selamat Datang, Kepala Balai.</h1>
            <p class="text-slate-500 text-sm mt-2 font-medium max-w-xl">Sistem telah mengonsolidasi seluruh data operasional dan analitik K-Means untuk memberikan gambaran strategis hari ini.</p>
        </div>

        <div class="relative z-10">
            <a href="<?= base_url('laporan/eksekutif') ?>" target="_blank" class="group relative inline-flex items-center gap-4 px-8 py-5 bg-slate-900 text-white rounded-[1.5rem] shadow-2xl hover:bg-slate-800 transition-all duration-300 active:scale-95">
                <div class="absolute -inset-1 bg-gradient-to-r from-amber-400 to-amber-600 rounded-[1.6rem] blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                
                <div class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-slate-900 shadow-lg group-hover:rotate-12 transition-transform">
                    <svg class="w-6 h-6 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <span class="block text-[10px] font-black uppercase tracking-[0.2em] text-amber-400 mb-0.5">Generate Smart Report</span>
                    <span class="text-lg font-extrabold tracking-tight">Unduh Ringkasan Eksekutif</span>
                </div>
                <svg class="w-5 h-5 ml-4 text-slate-500 group-hover:text-amber-400 group-hover:translate-x-2 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-8 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden flex flex-col justify-between group">
            <div class="absolute inset-0 opacity-10 z-0 pointer-events-none" style="background-image: radial-gradient(#f59e0b 2px, transparent 2px); background-size: 30px 30px;"></div>
            
            <div class="relative z-10">
                <div class="flex justify-between items-start">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Kapitalisasi Aset Gudang</h3>
                    <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] font-black rounded-lg border border-emerald-500/20 uppercase tracking-widest">Real-Time Valuation</span>
                </div>
                <div class="flex items-baseline gap-4 mt-4">
                    <span class="text-3xl font-bold text-amber-500">Rp</span>
                    <span class="text-7xl font-black tracking-tighter text-white drop-shadow-xl">
                        <?= number_format($total_nilai, 0, ',', '.') ?>
                    </span>
                </div>
            </div>

            <div class="relative z-10 mt-16 flex items-center gap-12 border-t border-white/10 pt-8">
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Status Neraca</p>
                    <p class="text-base font-extrabold text-emerald-400 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Kondisi Sehat
                    </p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Tersebar Pada</p>
                    <p class="text-base font-extrabold text-slate-200"><?= $total_sku ?? 0 ?> Master Item</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Efisiensi AI</h3>
                </div>
                
                <div class="space-y-4">
                    <?php 
                    $colors = [
                        'Fast Moving' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100'],
                        'Slow Moving' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-100'],
                        'Dead Stock'  => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-100']
                    ];
                    foreach($rekap_kmeans as $r): 
                        $c = $colors[$r['label_klaster']] ?? ['bg' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-100'];
                    ?>
                    <div class="flex items-center justify-between p-4 rounded-2xl border <?= $c['bg'] ?> <?= $c['border'] ?> transition-transform hover:scale-[1.02] cursor-default">
                        <span class="text-[11px] font-bold uppercase tracking-widest <?= $c['text'] ?>"><?= $r['label_klaster'] ?></span>
                        <span class="text-2xl font-black <?= $c['text'] ?>"><?= $r['total'] ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <p class="mt-8 text-[10px] text-slate-400 leading-relaxed font-medium uppercase tracking-widest text-center">Hasil kalkulasi algoritma K-Means harian.</p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>