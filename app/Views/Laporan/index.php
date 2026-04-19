<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="p-8">
    <div class="mb-10">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Report Center</h2>
        <p class="text-slate-500 mt-1.5 text-sm font-medium">Pusat generasi dokumen laporan analitik dan rekapitulasi data manajerial.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="mb-10 bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 flex flex-col md:flex-row items-center gap-10">
        <div class="w-full md:w-1/3 relative h-64 flex justify-center">
            <canvas id="kMeansDonut"></canvas>
            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                <span class="text-3xl font-black text-slate-800" id="totalSkuChart">0</span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total SKU</span>
            </div>
        </div>
        <div class="w-full md:w-2/3">
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-0.5 bg-indigo-50 rounded text-[10px] font-bold uppercase tracking-widest text-indigo-600">AI Clustering</span>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-900 mb-2">K-Means Health Distribution</h3>
            <p class="text-sm text-slate-500 mb-6">Visualisasi status inventori saat ini. Barang berlabel "Dead Stock" menyita ruang gudang dan butuh likuidasi segera, sementara "Fast Moving" memerlukan prioritas restock.</p>
            
            <div class="flex flex-wrap gap-4" id="chartLegend">
                </div>
        </div>
    </div>

    <script>
        const chartData = <?= json_encode($kmeans_chart ?? []) ?>;
        const ctx = document.getElementById('kMeansDonut').getContext('2d');
        
        let labels = [];
        let dataValues = [];
        let backgroundColors = [];
        let totalItems = 0;

        // Pemetaan warna Enterprise
        const colorMap = {
            'Fast Moving': '#10b981', // Emerald
            'Slow Moving': '#f59e0b', // Amber
            'Dead Stock':  '#f43f5e'  // Rose
        };

        chartData.forEach(item => {
            labels.push(item.label_klaster);
            dataValues.push(item.total);
            backgroundColors.push(colorMap[item.label_klaster] || '#64748b');
            totalItems += parseInt(item.total);
            
            // Render Legend Manual agar lebih cantik
            document.getElementById('chartLegend').innerHTML += `
                <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                    <div class="w-3 h-3 rounded-full" style="background-color: ${colorMap[item.label_klaster] || '#ccc'}"></div>
                    <span class="text-sm font-bold text-slate-700">${item.label_klaster} <span class="text-slate-400 ml-1">(${item.total})</span></span>
                </div>
            `;
        });

        document.getElementById('totalSkuChart').innerText = totalItems;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: dataValues,
                    backgroundColor: backgroundColors,
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%', // Ketebalan donat
                plugins: {
                    legend: { display: false }, // Kita pakai legend kustom di HTML
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        padding: 12,
                        titleFont: { size: 13, family: 'Inter' },
                        bodyFont: { size: 14, weight: 'bold', family: 'Inter' },
                        displayColors: true,
                        boxPadding: 6
                    }
                }
            }
        });
    </script>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <?php 
        $reports = [
            ['id' => 'inventori_master', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'title' => 'Master Inventory Recap', 'desc' => 'Daftar lengkap SKU dan kategori.'],
            ['id' => 'stok_kritis', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', 'title' => 'Critical Stock Alerts', 'desc' => 'Barang yang butuh restock segera.'],
            ['id' => 'inbound_rekap', 'icon' => 'M7 11l5-5m0 0l5 5m-5-5v12', 'title' => 'Inbound Volume', 'desc' => 'Rekap penerimaan barang.'],
            ['id' => 'outbound_rekap', 'icon' => 'M17 13l-5 5m0 0l-5-5m5 5V6', 'title' => 'Outbound Volume', 'desc' => 'Rekap pengeluaran & distribusi.'],
            ['id' => 'valuasi_aset', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Warehouse Valuation', 'desc' => 'Konversi stok menjadi nilai Rupiah.'],
            ['id' => 'kinerja_supplier', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'title' => 'Supplier Performance', 'desc' => 'Analisis volume vendor masuk.'],
            ['id' => 'distribusi_customer', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Customer Distribution', 'desc' => 'Analisis serapan pelanggan.'],
            ['id' => 'analitik_kmeans', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'title' => 'K-Means Analytics', 'desc' => 'Laporan klasterisasi algoritma.']
        ];
        ?>

        <?php foreach($reports as $index => $rep): ?>
        <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 flex flex-col hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $rep['icon'] ?>"></path></svg>
            </div>
            <h3 class="font-bold text-slate-800 text-base mb-1"><?= $rep['title'] ?></h3>
            <p class="text-xs text-slate-500 mb-6 flex-1"><?= $rep['desc'] ?></p>
            
            <a href="<?= base_url('laporan/generate/' . $rep['id']) ?>" class="w-full text-center py-2.5 px-4 bg-white border border-slate-200 text-slate-700 rounded-xl text-xs font-bold hover:bg-slate-50 hover:border-indigo-300 hover:text-indigo-700 transition-colors">
                Generate Data
            </a>
        </div>
        <?php endforeach; ?>

    </div>
</div>

<?= $this->endSection() ?>