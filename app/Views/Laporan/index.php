<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="p-8">
    <div class="mb-10">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Report Center</h2>
        <p class="text-slate-500 mt-1.5 text-sm font-medium">Pusat generasi dokumen PDF resmi berskala Enterprise untuk ke-11 modul manajerial.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="mb-10 bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 flex flex-col md:flex-row items-center gap-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-gradient-to-br from-indigo-50 to-fuchsia-50 opacity-70 blur-3xl pointer-events-none"></div>

        <div class="w-full md:w-1/3 relative h-64 flex justify-center drop-shadow-sm">
            <canvas id="kMeansDonut"></canvas>
            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                <span class="text-4xl font-black text-slate-800 tracking-tight" id="totalSkuChart">0</span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1">Clustered SKU</span>
            </div>
        </div>
        
        <div class="w-full md:w-2/3 relative z-10">
            <div class="flex items-center gap-2 mb-3">
                <span class="px-2.5 py-1 bg-gradient-to-r from-indigo-500 to-violet-500 text-white rounded-lg text-[9px] font-black uppercase tracking-[0.2em] shadow-sm shadow-indigo-200">AI Clustering</span>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-900 mb-3 tracking-tight">K-Means Health Distribution</h3>
            <p class="text-sm text-slate-500 mb-6 leading-relaxed max-w-2xl">Visualisasi status inventori saat ini. Barang berlabel <b class="text-rose-500">Dead Stock</b> menyita ruang gudang dan butuh likuidasi segera, sementara <b class="text-emerald-500">Fast Moving</b> memerlukan prioritas restock berkala.</p>
            <div class="flex flex-wrap gap-3" id="chartLegend"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php 
        $reports = [
            ['id' => 'master_inventori', 'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16', 'title' => '1. Master Inventori Global', 'desc' => 'Daftar lengkap data SKU dan kategori.'],
            ['id' => 'barang_masuk', 'icon' => 'M7 11l5-5m0 0l5 5m-5-5v12', 'title' => '2. Transaksi Masuk', 'desc' => 'Histori penerimaan / Inbound log.'],
            ['id' => 'barang_keluar', 'icon' => 'M17 13l-5 5m0 0l-5-5m5 5V6', 'title' => '3. Distribusi Keluar', 'desc' => 'Histori distribusi / Outbound log.'],
            ['id' => 'stok_kritis', 'icon' => 'M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => '4. Ambang Stok Kritis', 'desc' => 'Daftar barang yang butuh restock.'],
            ['id' => 'fast_moving', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => '5. Kinerja Fast Moving', 'desc' => 'Klaster algoritma barang terlaris.'],
            ['id' => 'slow_moving', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => '6. Kinerja Slow Moving', 'desc' => 'Klaster algoritma sirkulasi lambat.'],
            ['id' => 'dead_stock', 'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636', 'title' => '7. Indikasi Dead Stock', 'desc' => 'Klaster indikasi barang macet.'],
            ['id' => 'retur_audit', 'icon' => 'M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6', 'title' => '8. Audit Pengembalian', 'desc' => 'Catatan retur dan aksi sistem.'],
            ['id' => 'kinerja_supplier', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5', 'title' => '9. Kinerja Pemasok', 'desc' => 'Analisis total pasokan per vendor.'],
            ['id' => 'valuasi_aset', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => '10. Valuasi Aset Terkini', 'desc' => 'Nilai kapital aset dalam Rupiah.'],
            ['id' => 'system_log', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => '11. System Audit Log', 'desc' => 'Jejak rekam aktivitas pengguna.']
        ];
        ?>

        <?php foreach($reports as $rep): ?>
        <div class="group bg-white p-6 rounded-[1.5rem] shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 flex flex-col hover:-translate-y-1.5 hover:shadow-[0_12px_30px_rgb(79,70,229,0.08)] hover:border-indigo-100 transition-all duration-300 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col h-full">
                <div class="flex items-start gap-4 mb-3">
                    <div class="w-12 h-12 bg-slate-50 text-slate-400 group-hover:bg-indigo-600 group-hover:text-white rounded-2xl flex items-center justify-center shrink-0 transition-all duration-300 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $rep['icon'] ?>"></path></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm leading-snug group-hover:text-indigo-900 transition-colors pt-1"><?= $rep['title'] ?></h3>
                </div>
                <p class="text-[11px] text-slate-500 mb-6 flex-1 font-medium"><?= $rep['desc'] ?></p>
                
                <a href="<?= base_url('laporan/generate/' . $rep['id']) ?>" target="_blank" class="w-full text-center py-3 bg-white border border-slate-200 text-slate-600 rounded-xl text-[11px] font-bold uppercase tracking-wider hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-700 active:scale-95 transition-all duration-200 flex justify-center items-center gap-2">
                    Generate PDF
                    <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    // JS Chart - Optimized
    const chartData = <?= json_encode($kmeans_chart ?? []) ?>;
    const ctx = document.getElementById('kMeansDonut').getContext('2d');
    let labels = [], dataValues = [], backgroundColors = [], totalItems = 0;
    
    const colorMap = { 
        'Fast Moving': '#10b981', // Emerald
        'Slow Moving': '#f59e0b', // Amber
        'Dead Stock': '#f43f5e'   // Rose
    };

    chartData.forEach(item => {
        labels.push(item.label_klaster);
        dataValues.push(item.total);
        backgroundColors.push(colorMap[item.label_klaster] || '#94a3b8');
        totalItems += parseInt(item.total);
        
        document.getElementById('chartLegend').innerHTML += `
            <div class="flex items-center gap-2.5 bg-white px-3.5 py-2 rounded-xl border border-slate-100 shadow-sm">
                <div class="w-2.5 h-2.5 rounded-full shadow-inner" style="background-color: ${colorMap[item.label_klaster] || '#ccc'}"></div>
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wide">${item.label_klaster} <span class="text-slate-400 ml-1">(${item.total})</span></span>
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
            cutout: '78%', 
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { family: 'Inter', size: 12 },
                    bodyFont: { family: 'Inter', size: 14, weight: 'bold' },
                    padding: 12,
                    cornerRadius: 12,
                    displayColors: true
                }
            },
            animation: { animateScale: true, animateRotate: true }
        }
    });
</script>
<?= $this->endSection() ?>