<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4 py-5">
    <div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Ringkasan Logistik</h1>
        <p class="text-gray-500">Pantau status inventori dan hasil analitik secara real-time.</p>
    </div>
    <a href="<?= base_url('home/exportPDF') ?>" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        Export PDF
    </a>
</div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total SKU Barang</p>
                    <p class="text-3xl font-bold text-gray-800"><?= $total_barang ?></p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="box"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Stok Kritis</p>
                    <p class="text-3xl font-bold text-red-600"><?= $low_stock ?></p>
                </div>
                <div class="p-3 bg-red-50 rounded-lg">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-400 font-medium">*Barang dengan stok <= batas kritis</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Status Analitik</p>
                    <p class="text-xl font-bold text-green-600">K-Means Aktif</p>
                </div>
                <div class="p-3 bg-green-50 rounded-lg">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold mb-6 text-gray-800">Distribusi Klaster Barang (K-Means)</h3>
        
        <?php if(empty($rekap_kmeans)): ?>
            <div class="text-center py-10">
                <p class="text-gray-400 italic">Belum ada data analitik. Silakan jalankan algoritma di menu Analitik.</p>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php foreach($rekap_kmeans as $r): 
                    // Logika warna progress bar
                    $colorClass = 'bg-gray-400';
                    if($r['label_klaster'] == 'Fast Moving') $colorClass = 'bg-green-500';
                    if($r['label_klaster'] == 'Slow Moving') $colorClass = 'bg-yellow-500';
                    if($r['label_klaster'] == 'Dead Stock') $colorClass = 'bg-red-500';
                    
                    $percentage = ($total_barang > 0) ? ($r['total'] / $total_barang) * 100 : 0;
                ?>
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-gray-700"><?= $r['label_klaster'] ?></span>
                        <span class="text-sm font-bold text-gray-600"><?= $r['total'] ?> Item (<?= round($percentage) ?>%)</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3">
                        <div class="<?= $colorClass ?> h-3 rounded-full transition-all duration-500" style="width: <?= $percentage ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 mt-8">
    <h3 class="text-lg font-bold mb-6 text-gray-800">Analisis Spasial Klaster (Velocity vs Stok)</h3>
    <div style="height: 400px;">
        <canvas id="kmeansChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const rawData = <?= $plot_data ?>;
    
    // Kelompokkan data berdasarkan label untuk warna yang berbeda
    const datasets = {
        'Fast Moving': { label: 'Fast Moving', data: [], backgroundColor: '#22c55e' },
        'Slow Moving': { label: 'Slow Moving', data: [], backgroundColor: '#eab308' },
        'Dead Stock': { label: 'Dead Stock', data: [], backgroundColor: '#ef4444' }
    };

    rawData.forEach(item => {
        if (datasets[item.label_klaster]) {
            datasets[item.label_klaster].data.push({
                x: item.x,
                y: item.y,
                name: item.nama_barang
            });
        }
    });

    const ctx = document.getElementById('kmeansChart').getContext('2d');
    new Chart(ctx, {
        type: 'scatter',
        data: { datasets: Object.values(datasets) },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { title: { display: true, text: 'Velocity (Total Keluar)' } },
                y: { title: { display: true, text: 'Stok Aktual' } }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: (ctx) => `${ctx.raw.name}: (Vel: ${ctx.raw.x}, Stok: ${ctx.raw.y})`
                    }
                }
            }
        }
    });
</script>
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mt-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-800">Riwayat Aktivitas Gudang</h3>
        <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded">5 Aktivitas Terakhir</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-400 text-xs uppercase tracking-wider border-b">
                    <th class="pb-3 font-semibold">Waktu</th>
                    <th class="pb-3 font-semibold">Modul</th>
                    <th class="pb-3 font-semibold">Aksi / Keterangan</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                <?php foreach($recent_logs as $log): ?>
                <tr class="border-b last:border-0 hover:bg-gray-50 transition-colors">
                    <td class="py-4 whitespace-nowrap">
                        <span class="font-medium"><?= date('d/m H:i', strtotime($log['waktu'])) ?></span>
                    </td>
                    <td class="py-4">
                        <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase <?= $log['modul'] == 'Inbound' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' ?>">
                            <?= $log['modul'] ?>
                        </span>
                    </td>
                    <td class="py-4"><?= $log['aksi'] ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($recent_logs)): ?>
                <tr>
                    <td colspan="3" class="py-6 text-center text-gray-400 italic">Belum ada aktivitas tercatat.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>


<?= $this->endSection() ?>