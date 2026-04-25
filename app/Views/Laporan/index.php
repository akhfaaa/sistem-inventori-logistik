<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-[1400px] mx-auto px-6 py-8">
    
    <div class="mb-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8 bg-white p-8 md:p-10 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-amber-100 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

        <div class="relative z-10">
            <div class="inline-flex items-center px-3 py-1 bg-slate-900 text-amber-400 text-[10px] font-black rounded-lg border border-slate-700 mb-4 uppercase tracking-widest shadow-sm">
                Document Control Center
            </div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Pusat Laporan Terpadu</h1>
            <p class="text-slate-500 text-sm mt-2 font-medium max-w-xl leading-relaxed">Pusat generasi dokumen resmi berskala Enterprise. Meliputi operasional, rekam jejak, hingga analitik logistik Bapekom VII.</p>
        </div>

        <div class="relative z-10 shrink-0">
            <a href="<?= base_url('laporan/eksekutif') ?>" target="_blank" class="group relative inline-flex items-center gap-4 px-8 py-5 bg-slate-900 text-white rounded-[1.5rem] shadow-2xl hover:bg-slate-800 transition-all duration-300 active:scale-95">
                <div class="absolute -inset-1 bg-gradient-to-r from-amber-400 to-amber-600 rounded-[1.6rem] blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                <div class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-slate-900 shadow-lg group-hover:rotate-12 transition-transform">
                    <svg class="w-6 h-6 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <span class="block text-[10px] font-black uppercase tracking-[0.2em] text-amber-400 mb-0.5">Laporan Keseluruhan</span>
                    <span class="text-lg font-extrabold tracking-tight">Unduh Executive Summary</span>
                </div>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <div class="mb-12 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-8 md:p-10 rounded-[2.5rem] shadow-2xl flex flex-col md:flex-row items-center gap-12 relative overflow-hidden border border-slate-700">
        <div class="absolute inset-0 opacity-[0.03] z-0 pointer-events-none" style="background-image: linear-gradient(#f59e0b 1px, transparent 1px), linear-gradient(90deg, #f59e0b 1px, transparent 1px); background-size: 40px 40px;"></div>
        
        <div class="w-full md:w-1/3 relative h-56 flex justify-center drop-shadow-lg z-10">
            <canvas id="kMeansDonut"></canvas>
            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none mt-2">
                <span class="text-5xl font-black text-white tracking-tighter" id="totalSkuChart">0</span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1">Total Aset</span>
            </div>
        </div>
        
        <div class="w-full md:w-2/3 relative z-10">
            <div class="flex items-center gap-2 mb-4">
                <span class="px-2.5 py-1 bg-white/10 backdrop-blur-md text-amber-400 rounded-lg text-[9px] font-black uppercase tracking-[0.2em] border border-white/10 flex items-center gap-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></div> K-Means Algorithm
                </span>
            </div>
            <h3 class="text-3xl font-extrabold text-white mb-4 tracking-tight">Kesehatan Inventori Saat Ini</h3>
            <p class="text-sm text-slate-400 mb-8 leading-relaxed max-w-2xl font-medium">Visualisasi perbandingan volume aset. Komposisi laporan manajerial sangat dipengaruhi oleh persentase barang pada klaster <b class="text-emerald-400">Fast Moving</b> dan <b class="text-rose-400">Dead Stock</b>.</p>
            <div class="flex flex-wrap gap-3" id="chartLegend"></div>
        </div>
    </div>

    <?php 
    $reportCategories = [
        'Operasional & Mutasi Logistik' => [
            'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16',
            'desc' => 'Dokumen rekapitulasi data master dan jejak perpindahan fisik barang (masuk/keluar).',
            'reports' => [
                ['id' => 'master_inventori', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', 'title' => 'Master Inventori Global', 'desc' => 'Daftar lengkap katalog aset beserta kuantitas.'],
                ['id' => 'barang_masuk', 'icon' => 'M7 11l5-5m0 0l5 5m-5-5v12', 'title' => 'Log Penerimaan (Inbound)', 'desc' => 'Histori transaksi aset masuk dari supplier.'],
                ['id' => 'barang_keluar', 'icon' => 'M17 13l-5 5m0 0l-5-5m5 5V6', 'title' => 'Log Distribusi (Outbound)', 'desc' => 'Histori pengeluaran aset ke unit kerja.'],
                ['id' => 'retur_audit', 'icon' => 'M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6', 'title' => 'Buku Register Retur', 'desc' => 'Catatan pengembalian dan pemusnahan barang.'],
            ]
        ],
        'Analitik Kecerdasan Buatan & Stok' => [
            'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
            'desc' => 'Laporan hasil pemrosesan algoritma K-Means dan peringatan dini stok.',
            'reports' => [
                ['id' => 'fast_moving', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Klaster Fast Moving', 'desc' => 'Data barang rotasi cepat (Prioritas Tinggi).', 'color' => 'emerald'],
                ['id' => 'slow_moving', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Klaster Slow Moving', 'desc' => 'Data sirkulasi barang yang melambat.', 'color' => 'amber'],
                ['id' => 'dead_stock', 'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636', 'title' => 'Indikasi Dead Stock', 'desc' => 'Aset tak bergerak yang membebani gudang.', 'color' => 'rose'],
                ['id' => 'stok_kritis', 'icon' => 'M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Ambang Stok Kritis', 'desc' => 'Daftar barang yang butuh tindakan restock.', 'color' => 'slate'],
            ]
        ],
        'Audit, Valuasi & Sistem' => [
            'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
            'desc' => 'Dokumen evaluasi nilai aset secara finansial dan rekam jejak pengguna.',
            'reports' => [
                ['id' => 'valuasi_aset', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Kalkulasi Valuasi Aset', 'desc' => 'Estimasi nilai kapital aset dalam satuan Rupiah.'],
                ['id' => 'kinerja_supplier', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5', 'title' => 'Performa Pemasok', 'desc' => 'Evaluasi kontribusi pasokan logistik per vendor.'],
                ['id' => 'system_log', 'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4', 'title' => 'System Audit Log', 'desc' => 'Jejak rekam aktivitas dan otorisasi pengguna.'],
            ]
        ]
    ];
    ?>

    <div class="space-y-12">
        <?php foreach($reportCategories as $categoryName => $categoryData): ?>
        <div>
            <div class="mb-6 flex items-start gap-4 border-b border-slate-200 pb-4">
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center border border-slate-200 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $categoryData['icon'] ?>"></path></svg>
                </div>
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900"><?= $categoryName ?></h2>
                    <p class="text-[11px] font-medium text-slate-500 uppercase tracking-widest mt-1"><?= $categoryData['desc'] ?></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <?php foreach($categoryData['reports'] as $rep): 
                    $iconBg = 'bg-slate-50 text-slate-400 group-hover:bg-amber-100 group-hover:text-amber-700';
                    if(isset($rep['color'])) {
                        $c = $rep['color'];
                        $iconBg = "bg-{$c}-50 text-{$c}-500 group-hover:bg-{$c}-100 group-hover:text-{$c}-700";
                    }
                ?>
                <a href="<?= base_url('laporan/generate/' . $rep['id']) ?>" target="_blank" class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-slate-300 hover:-translate-y-1 transition-all duration-300 flex flex-col relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-amber-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 rounded-xl <?= $iconBg ?> flex items-center justify-center transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $rep['icon'] ?>"></path></svg>
                            </div>
                            <div class="px-2 py-1 bg-slate-100 text-slate-400 text-[9px] font-black uppercase tracking-widest rounded flex items-center gap-1 group-hover:bg-slate-900 group-hover:text-amber-400 transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                PDF
                            </div>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base leading-tight mb-2 group-hover:text-amber-600 transition-colors"><?= $rep['title'] ?></h3>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed mb-6 flex-1"><?= $rep['desc'] ?></p>
                        <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 group-hover:text-slate-900 transition-colors pt-4 border-t border-slate-100">
                            Cetak Laporan
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chartData = <?= json_encode($kmeans_chart ?? []) ?>;
        const ctxElem = document.getElementById('kMeansDonut');
        if (!ctxElem) return;

        const ctx = ctxElem.getContext('2d');
        let labels = [], dataValues = [], backgroundColors = [], totalItems = 0;
        const colorMap = { 'Fast Moving': '#10b981', 'Slow Moving': '#f59e0b', 'Dead Stock': '#f43f5e' };
        const legendContainer = document.getElementById('chartLegend');

        chartData.forEach(item => {
            labels.push(item.label_klaster);
            dataValues.push(item.total);
            backgroundColors.push(colorMap[item.label_klaster] || '#64748b');
            totalItems += parseInt(item.total);
            
            if(legendContainer) {
                legendContainer.innerHTML += `
                    <div class="flex items-center gap-2.5 bg-slate-800/50 backdrop-blur-sm px-4 py-2 rounded-xl border border-slate-700/50">
                        <div class="w-3 h-3 rounded-full" style="background-color: ${colorMap[item.label_klaster] || '#ccc'}"></div>
                        <span class="text-[10px] font-bold text-slate-200 uppercase tracking-widest">${item.label_klaster} <span class="text-slate-400 ml-1">(${item.total})</span></span>
                    </div>
                `;
            }
        });
        
        const totalElem = document.getElementById('totalSkuChart');
        if(totalElem) totalElem.innerText = totalItems;

        new Chart(ctx, {
            type: 'doughnut',
            data: { labels: labels, datasets: [{ data: dataValues, backgroundColor: backgroundColors, borderWidth: 0, hoverOffset: 4 }] },
            options: { 
                responsive: true, maintainAspectRatio: false, cutout: '75%', 
                plugins: { legend: { display: false }, tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.95)', titleColor: '#f8fafc', bodyColor: '#cbd5e1', titleFont: { family: 'Inter', size: 11, weight: 'black' }, bodyFont: { family: 'Inter', size: 12, weight: 'bold' }, padding: 12, cornerRadius: 12, displayColors: false } },
            }
        });
    });
</script>
<?= $this->endSection() ?>