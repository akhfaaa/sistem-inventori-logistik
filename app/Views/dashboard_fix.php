<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="min-h-screen bg-[#F8FAFC] p-4 sm:p-8 font-sans">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Logistics Hub <span class="text-indigo-600">Enterprise</span></h1>
            <p class="text-slate-500 mt-1.5 text-sm font-medium">Monitoring inventori cerdas didukung analitik spasial.</p>
        </div>
        <a href="<?= base_url('home/exportPDF') ?>" class="group flex items-center gap-2 bg-white border border-slate-200 hover:border-indigo-300 hover:shadow-md text-slate-700 hover:text-indigo-700 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300">
            <svg class="w-5 h-5 text-indigo-500 group-hover:-translate-y-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Generate Executive Report
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full">LIVE</span>
            </div>
            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Active SKU</p>
            <p class="text-4xl font-extrabold text-slate-900"><?= $total_barang ?></p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-shadow duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-rose-50 rounded-bl-full -z-10"></div>
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Critical Stock Level</p>
            <div class="flex items-baseline gap-2">
                <p class="text-4xl font-extrabold text-rose-600"><?= $low_stock ?></p>
                <p class="text-sm font-medium text-slate-400">Items need attention</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-shadow duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -z-10"></div>
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Algorithm Status</p>
            <p class="text-2xl font-bold text-emerald-600 mt-2">K-Means Optimal</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <div class="lg:col-span-1 bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 flex flex-col">
            <div class="mb-8">
                <h3 class="text-lg font-bold text-slate-900">Cluster Distribution</h3>
                <p class="text-sm text-slate-500 mt-1">Real-time K-Means grouping results</p>
            </div>
            
            <?php if(empty($rekap_kmeans)): ?>
                <div class="flex-1 flex flex-col items-center justify-center text-center p-6 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    <svg class="w-10 h-10 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <p class="text-sm text-slate-500 font-medium">Data analitik belum tersedia.</p>
                </div>
            <?php else: ?>
                <div class="space-y-6 flex-1">
                    <?php foreach($rekap_kmeans as $r): 
                        $colorClass = 'bg-slate-800';
                        $bgSoft = 'bg-slate-100';
                        if($r['label_klaster'] == 'Fast Moving') { $colorClass = 'bg-emerald-500'; $bgSoft = 'bg-emerald-50'; }
                        if($r['label_klaster'] == 'Slow Moving') { $colorClass = 'bg-amber-400'; $bgSoft = 'bg-amber-50'; }
                        if($r['label_klaster'] == 'Dead Stock') { $colorClass = 'bg-rose-500'; $bgSoft = 'bg-rose-50'; }
                        
                        $percentage = ($total_barang > 0) ? ($r['total'] / $total_barang) * 100 : 0;
                    ?>
                    <div class="group p-4 rounded-xl <?= $bgSoft ?> border border-transparent hover:border-white transition-all">
                        <div class="flex justify-between items-end mb-3">
                            <span class="font-bold text-slate-800 tracking-tight"><?= $r['label_klaster'] ?></span>
                            <div class="text-right">
                                <span class="block text-xl font-extrabold text-slate-900 leading-none mb-1"><?= $r['total'] ?></span>
                                <span class="text-xs font-semibold text-slate-500"><?= round($percentage) ?>% of Total</span>
                            </div>
                        </div>
                        <div class="w-full bg-white/60 rounded-full h-2.5 overflow-hidden shadow-inner">
                            <div class="<?= $colorClass ?> h-2.5 rounded-full transition-all duration-1000 ease-out" style="width: <?= $percentage ?>%"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="lg:col-span-2 bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Spatial Intelligence</h3>
                    <p class="text-sm text-slate-500 mt-1">Velocity vs Actual Stock projection</p>
                </div>
                <div class="p-2 bg-slate-50 rounded-lg border border-slate-100">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="relative w-full rounded-xl overflow-hidden" style="height: 420px;">
                <canvas id="kmeansChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Activity Audit Trail</h3>
                <p class="text-sm text-slate-500 mt-1">Secure system activity tracking</p>
            </div>
            <button class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">View All Logs &rarr;</button>
        </div>
        
        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-widest font-semibold">
                        <th class="px-6 py-4 border-b border-slate-100">Timestamp</th>
                        <th class="px-6 py-4 border-b border-slate-100">Module</th>
                        <th class="px-6 py-4 border-b border-slate-100">Action Detail</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <?php foreach($recent_logs as $index => $log): 
                        $isEven = $index % 2 === 0;
                        $rowBg = $isEven ? 'bg-white' : 'bg-slate-50/50';
                    ?>
                    <tr class="<?= $rowBg ?> hover:bg-indigo-50/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap border-b border-slate-50 text-slate-600 font-medium">
                            <?= date('M d, Y • H:i', strtotime($log['waktu'])) ?>
                        </td>
                        <td class="px-6 py-4 border-b border-slate-50">
                            <?php 
                                $badgeColor = $log['modul'] == 'Inbound' ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-amber-100 text-amber-700 border-amber-200';
                            ?>
                            <span class="px-3 py-1.5 rounded-md text-xs font-bold uppercase tracking-wider border <?= $badgeColor ?>">
                                <?= $log['modul'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 border-b border-slate-50 text-slate-700">
                            <?= $log['aksi'] ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if(empty($recent_logs)): ?>
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-slate-400 italic bg-slate-50">
                            No recent activity found in the secure audit log.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const rawData = <?= $plot_data ?>;
    
    // Enterprise color palette for Chart.js
    const datasets = {
        'Fast Moving': { label: 'Fast Moving', data: [], backgroundColor: '#10b981', borderColor: '#059669', borderWidth: 1, pointRadius: 6, pointHoverRadius: 8 },
        'Slow Moving': { label: 'Slow Moving', data: [], backgroundColor: '#fbbf24', borderColor: '#d97706', borderWidth: 1, pointRadius: 6, pointHoverRadius: 8 },
        'Dead Stock': { label: 'Dead Stock', data: [], backgroundColor: '#f43f5e', borderColor: '#e11d48', borderWidth: 1, pointRadius: 6, pointHoverRadius: 8 }
    };

    rawData.forEach(item => {
        if (datasets[item.label_klaster]) {
            datasets[item.label_klaster].data.push({ x: item.x, y: item.y, name: item.nama_barang });
        }
    });

    const ctx = document.getElementById('kmeansChart').getContext('2d');
    
    // Chart.js global font styling to match UI
    Chart.defaults.font.family = "'Inter', 'Segoe UI', Roboto, sans-serif";
    Chart.defaults.color = '#64748b';

    new Chart(ctx, {
        type: 'scatter',
        data: { datasets: Object.values(datasets) },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: 20 },
            scales: {
                x: { 
                    title: { display: true, text: 'Velocity Score (Total Outbound)', font: { weight: 'bold' } },
                    grid: { color: '#f1f5f9', drawBorder: false }
                },
                y: { 
                    title: { display: true, text: 'Actual Stock Level', font: { weight: 'bold' } },
                    grid: { color: '#f1f5f9', drawBorder: false }
                }
            },
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { weight: 'bold' } } },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: (ctx) => `${ctx.raw.name} — Velocity: ${ctx.raw.x} | Stock: ${ctx.raw.y}`
                    }
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>