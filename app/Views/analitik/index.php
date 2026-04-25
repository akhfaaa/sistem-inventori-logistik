<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-[1400px] mx-auto px-4 py-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <span class="w-2 h-8 bg-indigo-600 rounded-full"></span>
                SILABAK Spatial Intelligence
            </h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Pemetaan cerdas aset Bapekom VII menggunakan Algoritma K-Means.</p>
        </div>
        <form action="<?= base_url('analitik/proses') ?>" method="POST">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl text-xs font-black hover:bg-indigo-700 transition-all flex items-center gap-3 shadow-xl shadow-indigo-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                UPDATE ANALISIS AI
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

    <?php 
        $colors = [
            'Fast Moving' => ['bg-emerald-50', 'text-emerald-800', 'border-emerald-100', 'icon' => '⚡'],
            'Slow Moving' => ['bg-amber-50', 'text-amber-800', 'border-amber-100', 'icon' => '⏳'],
            'Dead Stock'  => ['bg-rose-50', 'text-rose-800', 'border-rose-100', 'icon' => '🛑']
        ];
        foreach($rekap as $r): 
            $c = $colors[$r['label_klaster']] ?? ['bg-slate-50', 'text-slate-800', 'border-slate-100', 'icon' => '📦'];
        ?>
        <div class="md:col-span-4 <?= $c[0] ?> p-8 rounded-[2rem] border <?= $c[2] ?> flex items-center justify-between group hover:scale-[1.02] transition-transform shadow-sm">
            <div>
                <span class="text-[10px] font-black opacity-50 uppercase tracking-widest block mb-1"><?= $r['label_klaster'] ?></span>
                <p class="text-4xl font-black <?= $c[1] ?> tracking-tighter"><?= $r['total'] ?> <span class="text-xs font-bold opacity-50 ml-1 uppercase">SKU</span></p>
            </div>
            <div class="text-3xl filter grayscale opacity-30 group-hover:grayscale-0 group-hover:opacity-100 transition-all"><?= $c['icon'] ?></div>
        </div>
        <?php endforeach; ?>
        
        <div class="md:col-span-8 bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between group">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Peta Radar Stok</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Koordinat: Kecepatan Rotasi vs Volume Fisik</p>
                </div>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> <span class="text-[9px] font-black text-slate-400 uppercase">Fast</span></div>
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span> <span class="text-[9px] font-black text-slate-400 uppercase">Slow</span></div>
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-rose-500"></span> <span class="text-[9px] font-black text-slate-400 uppercase">Dead</span></div>
                </div>
            </div>
            
            <div class="h-[420px] w-full">
                <canvas id="spatialChart"></canvas>
            </div>

            <div class="mt-6 flex justify-between text-[9px] font-black text-slate-300 uppercase tracking-[0.3em]">
                <span>← Volume Rendah</span>
                <span>Spatial Intelligence Mapping</span>
                <span>Volume Tinggi →</span>
            </div>
        </div>

        <div class="md:col-span-4 bg-slate-900 p-8 rounded-[2rem] text-white flex flex-col justify-between shadow-2xl">
            <div>
                <div class="inline-flex items-center px-2 py-1 bg-indigo-500/20 text-indigo-400 text-[9px] font-black rounded border border-indigo-500/30 mb-8 uppercase tracking-widest">
                    AI Insights
                </div>
                <h3 class="text-xl font-black mb-6 leading-tight">Panduan <br/>Operasional Cerdas</h3>
                
                <div class="space-y-8">
                    <div class="flex gap-4">
                        <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
                        <div>
                            <h4 class="text-[10px] font-black text-emerald-400 uppercase mb-1">Optimasi Pengadaan</h4>
                            <p class="text-[11px] opacity-70 leading-relaxed">Fokus pada barang <span class="font-bold text-white">Fast Moving</span> yang berada di kuadran rendah untuk menghindari kehabisan stok.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 border-t border-white/5 pt-6">
                        <div class="p-2 bg-rose-500/10 rounded-lg text-rose-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></div>
                        <div>
                            <h4 class="text-[10px] font-black text-rose-400 uppercase mb-1">Efisiensi Ruang</h4>
                            <p class="text-[11px] opacity-70 leading-relaxed">Barang <span class="font-bold text-white">Dead Stock</span> di kuadran tinggi membebani kapasitas rak. Disarankan pengurangan aset.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-10 pt-6 border-t border-white/5 flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[9px] font-bold opacity-40 uppercase tracking-widest text-slate-100">Status: Algoritma Aktif</span>
            </div>
        </div>

        

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('spatialChart').getContext('2d');
    const rawData = <?= json_encode($chart_spasial) ?>;
    
    const datasets = {
        'Fast Moving': { label: 'Fast Moving', data: [], backgroundColor: '#10b981', pointRadius: 10, hoverRadius: 15, borderColor: '#fff', borderWidth: 3 },
        'Slow Moving': { label: 'Slow Moving', data: [], backgroundColor: '#f59e0b', pointRadius: 10, hoverRadius: 15, borderColor: '#fff', borderWidth: 3 },
        'Dead Stock': { label: 'Dead Stock', data: [], backgroundColor: '#f43f5e', pointRadius: 10, hoverRadius: 15, borderColor: '#fff', borderWidth: 3 }
    };

    rawData.forEach(item => {
        if(datasets[item.label_klaster]) {
            datasets[item.label_klaster].data.push({ x: parseFloat(item.x), y: parseFloat(item.y), nama: item.nama_barang });
        }
    });

    new Chart(ctx, {
        type: 'scatter',
        data: { datasets: Object.values(datasets) },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { 
                    grid: { display: false }, 
                    ticks: { font: { weight: '900', size: 9 }, color: '#94a3b8' },
                    title: { display: true, text: 'VELOCITY (X)', font: { weight: 'bold', size: 8 }, color: '#cbd5e1' }
                },
                y: { 
                    grid: { color: '#f8fafc' }, 
                    ticks: { font: { weight: '900', size: 9 }, color: '#94a3b8' },
                    title: { display: true, text: 'STOCK (Y)', font: { weight: 'bold', size: 8 }, color: '#cbd5e1' }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    padding: 16,
                    cornerRadius: 12,
                    titleFont: { size: 12, weight: '900' },
                    bodyFont: { size: 11 },
                    callbacks: {
                        label: function(ctx) { return ` SKU: ${ctx.raw.nama} (Rotasi: ${ctx.raw.x}%, Stok: ${ctx.raw.y})`; }
                    }
                }
            }
        }
    });
});
</script>

<?= $this->endSection() ?>