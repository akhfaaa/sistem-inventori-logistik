<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-[1400px] mx-auto px-6 py-8">
    
    <div class="mb-10 bg-slate-900 rounded-[2rem] p-8 md:p-10 text-white shadow-2xl relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-8 border border-slate-800">
        <div class="absolute inset-0 opacity-[0.05] pointer-events-none" style="background-image: radial-gradient(#10b981 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/10 text-emerald-400 text-[10px] font-black rounded-lg border border-emerald-500/20 mb-4 uppercase tracking-[0.2em]">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></div>
                Machine Learning Core
            </div>
            <h1 class="text-3xl md:text-4xl font-black tracking-tight mb-2">Spatial Intelligence (AI)</h1>
            <p class="text-slate-400 text-sm font-medium max-w-2xl leading-relaxed">
                Modul ini menggunakan algoritma <b class="text-slate-200">K-Means Clustering</b> yang dioptimasi dengan parameter <b class="text-slate-200">RFM (Recency, Frequency, Monetary)</b> untuk memetakan kesehatan rotasi inventori secara presisi.
            </p>
        </div>

        <div class="relative z-10 shrink-0">
            <form action="<?= base_url('analitik/kalkulasi') ?>" method="POST" onsubmit="return confirm('Sistem akan menganalisis ulang seluruh data histori barang. Proses ini mungkin memakan waktu beberapa detik. Lanjutkan?');">
                <button type="submit" class="group relative px-8 py-4 bg-emerald-500 text-slate-900 rounded-2xl font-black uppercase tracking-widest text-sm hover:bg-emerald-400 transition-all shadow-[0_0_20px_rgba(16,185,129,0.3)] active:scale-95 flex items-center gap-3">
                    <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Jalankan Engine AI
                </button>
            </form>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="mb-8 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg flex items-start gap-3 shadow-sm">
            <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-bold text-emerald-800"><?= session()->getFlashdata('success') ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Peta Spasial Distribusi RFM</h3>
                <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400">X: Velocity Score | Y: Stok Aktual</span>
            </div>
            <div class="flex-1 min-h-[300px] relative w-full">
                <?php if(empty($klaster)): ?>
                    <div class="absolute inset-0 flex items-center justify-center border-2 border-dashed border-slate-200 rounded-xl">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Engine AI belum dijalankan.</p>
                    </div>
                <?php else: ?>
                    <canvas id="spatialChart"></canvas>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6">Distribusi Klaster</h3>
                <div class="space-y-4">
                    <?php 
                    $colors = [
                        'Fast Moving' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100'],
                        'Slow Moving' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-100'],
                        'Dead Stock'  => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-100']
                    ];
                    if(empty($rekap)): ?>
                        <p class="text-[10px] text-slate-400 text-center font-bold italic py-4">Data kosong.</p>
                    <?php else: foreach($rekap as $r): 
                        $c = $colors[$r['label_klaster']] ?? ['bg' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-100'];
                    ?>
                    <div class="flex items-center justify-between p-4 rounded-xl border <?= $c['bg'] ?> <?= $c['border'] ?>">
                        <span class="text-[11px] font-bold uppercase tracking-widest <?= $c['text'] ?>"><?= $r['label_klaster'] ?></span>
                        <span class="text-2xl font-black <?= $c['text'] ?>"><?= $r['total'] ?></span>
                    </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest">Detail Klasifikasi Master Aset</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-black border-b border-slate-100">
                        <th class="px-6 py-5">Identitas Aset</th>
                        <th class="px-6 py-5 text-center">Volume Aktual</th>
                        <th class="px-6 py-5 text-center">Velocity Score (AI)</th>
                        <th class="px-6 py-5 text-right">Hasil Klaster</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(empty($klaster)): ?>
                        <tr><td colspan="4" class="px-6 py-10 text-center text-sm font-bold text-slate-400">Belum ada data. Silakan jalankan Engine AI.</td></tr>
                    <?php else: foreach($klaster as $k): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-slate-900 block"><?= $k['nama_barang'] ?></span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5 block">ID: <?= $k['kode_barang'] ?></span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-slate-700"><?= $k['stok_aktual'] ?> Unit</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-black border border-slate-200"><?= $k['velocity_score'] ?></span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <?php 
                                    $badge = 'bg-slate-100 text-slate-500';
                                    if($k['label_klaster'] == 'Fast Moving') $badge = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                                    if($k['label_klaster'] == 'Slow Moving') $badge = 'bg-amber-100 text-amber-700 border-amber-200';
                                    if($k['label_klaster'] == 'Dead Stock') $badge = 'bg-rose-100 text-rose-700 border-rose-200';
                                ?>
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border <?= $badge ?>">
                                    <?= $k['label_klaster'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctxElem = document.getElementById('spatialChart');
    if(!ctxElem) return;

    // Menangkap data dari Controller
    const rawData = <?= json_encode($chart_spasial ?? []) ?>;
    
    const datasets = {
        'Fast Moving': { label: 'Fast Moving', data: [], backgroundColor: '#10b981', pointRadius: 6, hoverRadius: 8, borderColor: '#fff', borderWidth: 2 },
        'Slow Moving': { label: 'Slow Moving', data: [], backgroundColor: '#f59e0b', pointRadius: 6, hoverRadius: 8, borderColor: '#fff', borderWidth: 2 },
        'Dead Stock':  { label: 'Dead Stock', data: [], backgroundColor: '#f43f5e', pointRadius: 6, hoverRadius: 8, borderColor: '#fff', borderWidth: 2 }
    };

    // Memasukkan data ke dalam klaster masing-masing
    rawData.forEach(item => {
        if(datasets[item.label_klaster]) {
            datasets[item.label_klaster].data.push({ x: parseFloat(item.x), y: parseFloat(item.y), nama: item.nama_barang });
        }
    });

    new Chart(ctxElem.getContext('2d'), {
        type: 'scatter',
        data: { datasets: Object.values(datasets) },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { 
                    title: { display: true, text: 'Velocity Score (Kombinasi RFM)', font: { size: 10, weight: 'bold' } },
                    grid: { display: false } 
                },
                y: { 
                    title: { display: true, text: 'Stok Aktual (Unit)', font: { size: 10, weight: 'bold' } },
                    grid: { color: '#f8fafc' } 
                }
            },
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true, boxWidth: 8, font: { size: 11, weight: 'bold' } } },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: { size: 12, weight: 'bold' },
                    bodyFont: { size: 11 },
                    callbacks: {
                        label: function(ctx) { return `Aset: ${ctx.raw.nama} | Score: ${ctx.raw.x} | Stok: ${ctx.raw.y}`; }
                    }
                }
            }
        }
    });
});
</script>

<?= $this->endSection() ?>