<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-[1400px] mx-auto px-4 py-8">

    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="inline-flex items-center px-3 py-1 bg-slate-900 text-amber-400 text-[10px] font-black rounded-lg border border-slate-700 mb-3 uppercase tracking-widest shadow-sm">
                Command Center: Bapekom Wilayah VII
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard Logistik Terpadu</h1>
            <p class="text-slate-500 text-sm mt-1.5 font-medium">Pantauan operasional inventori, peringatan stok, dan performa kecerdasan buatan secara real-time.</p>
        </div>
        <div>
            <a href="<?= base_url('home/exportPDF') ?>" target="_blank" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Ekspor Laporan Master
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

        <div class="md:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-amber-200 transition-all">
                <div>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Master Aset</h3>
                    <div class="flex items-end gap-2">
                        <span class="text-5xl font-black text-slate-900 tracking-tighter"><?= $total_barang ?></span>
                        <span class="text-xs font-bold text-slate-400 mb-1.5 uppercase">SKU Terdaftar</span>
                    </div>
                </div>
                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-slate-900 group-hover:text-amber-400 transition-colors shadow-inner border border-slate-100 group-hover:border-slate-800">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-slate-900 p-8 rounded-3xl shadow-xl border border-slate-800 flex items-center justify-between relative overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-32 bg-rose-500/20 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none"></div>
                <div class="relative z-10">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-rose-500 <?= $low_stock > 0 ? 'animate-pulse' : '' ?>"></div>
                        Peringatan Stok Kritis
                    </h3>
                    <div class="flex items-end gap-2">
                        <span class="text-5xl font-black <?= $low_stock > 0 ? 'text-rose-500' : 'text-emerald-400' ?> tracking-tighter"><?= $low_stock ?></span>
                        <span class="text-xs font-bold text-slate-500 mb-1.5 uppercase">Item Butuh Restock</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="md:col-span-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-center">
            <h3 class="text-[10px] font-black text-slate-800 uppercase tracking-widest mb-4">Efisiensi Rotasi (AI)</h3>
            <div class="space-y-3">
                <?php
                $colors = [
                    'Fast Moving' => 'text-emerald-700 bg-emerald-50 border border-emerald-100',
                    'Slow Moving' => 'text-amber-700 bg-amber-50 border border-amber-100',
                    'Dead Stock'  => 'text-rose-700 bg-rose-50 border border-rose-100'
                ];
                if (empty($rekap_kmeans)): ?>
                    <p class="text-xs text-slate-400 font-bold italic text-center py-4">Belum ada klasterisasi AI.</p>
                    <?php else: foreach ($rekap_kmeans as $r):
                        $theme = $colors[$r['label_klaster']] ?? 'text-slate-600 bg-slate-50 border border-slate-100';
                    ?>
                        <div class="flex items-center justify-between p-3 rounded-xl <?= $theme ?>">
                            <span class="text-[10px] font-black uppercase tracking-widest"><?= $r['label_klaster'] ?></span>
                            <span class="text-lg font-black"><?= $r['total'] ?> <span class="text-[9px] opacity-70 font-bold uppercase">SKU</span></span>
                        </div>
                <?php endforeach;
                endif; ?>
            </div>
        </div>

        <div class="md:col-span-7 bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between group">
            <div class="flex justify-between items-start mb-8 border-b border-slate-50 pb-4">
                <div>
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Peta Distribusi Aset</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Sumbu X (Kecepatan Rotasi) vs Sumbu Y (Volume Aktual)</p>
                </div>
                <a href="<?= base_url('analitik') ?>" class="text-[10px] font-black text-amber-600 hover:text-amber-700 uppercase tracking-widest transition-colors flex items-center gap-1">
                    Buka Modul AI &rarr;
                </a>
            </div>

            <div class="h-[300px] w-full">
                <canvas id="spatialChart"></canvas>
            </div>
        </div>

        <div class="md:col-span-5 bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Jejak Aktivitas Sistem</h3>
            </div>

            <div class="flex-1 space-y-4 overflow-y-auto pr-2">
                <?php if (empty($recent_logs)): ?>
                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-tighter italic">
                        Otoritas: <?= $log['nama_lengkap'] ?? 'Pegawai Nonaktif' ?> (<?= $log['modul'] ?? 'Umum' ?>)
                    </span>
                    <?php else: foreach ($recent_logs as $log): ?>
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center mt-1">
                                <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                                <div class="w-px h-full bg-slate-200 my-1"></div>
                            </div>
                            <div class="pb-4">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-2 py-0.5 rounded border border-slate-100"><?= date('d M Y - H:i', strtotime($log['waktu'])) ?></span>
                                <p class="text-[11px] font-bold text-slate-800 leading-snug mt-2 mb-1"><?= $log['aktivitas'] ?></p>
                                <span class="text-[9px] font-black text-slate-500 uppercase tracking-tighter italic">Otoritas: <?= $log['nama_lengkap'] ?? 'System' ?> (<?= $log['modul'] ?? 'Umum' ?>)</span>
                            </div>
                        </div>
                <?php endforeach;
                endif; ?>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('spatialChart');
        if (!ctx) return;

        const rawData = <?= $plot_data ?? '[]' ?>;

        const datasets = {
            'Fast Moving': {
                label: 'Fast Moving',
                data: [],
                backgroundColor: '#10b981',
                pointRadius: 6,
                hoverRadius: 8,
                borderColor: '#fff',
                borderWidth: 1.5
            },
            'Slow Moving': {
                label: 'Slow Moving',
                data: [],
                backgroundColor: '#f59e0b',
                pointRadius: 6,
                hoverRadius: 8,
                borderColor: '#fff',
                borderWidth: 1.5
            },
            'Dead Stock': {
                label: 'Dead Stock',
                data: [],
                backgroundColor: '#f43f5e',
                pointRadius: 6,
                hoverRadius: 8,
                borderColor: '#fff',
                borderWidth: 1.5
            }
        };

        rawData.forEach(item => {
            if (datasets[item.label_klaster]) {
                datasets[item.label_klaster].data.push({
                    x: parseFloat(item.x),
                    y: parseFloat(item.y),
                    nama: item.nama_barang
                });
            }
        });

        new Chart(ctx.getContext('2d'), {
            type: 'scatter',
            data: {
                datasets: Object.values(datasets)
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                weight: 'bold',
                                size: 10,
                                family: 'Inter'
                            },
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        grid: {
                            color: '#f8fafc',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                weight: 'bold',
                                size: 10,
                                family: 'Inter'
                            },
                            color: '#94a3b8'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: {
                            size: 11,
                            weight: 'black',
                            family: 'Inter'
                        },
                        bodyFont: {
                            size: 11,
                            family: 'Inter',
                            weight: '500'
                        },
                        displayColors: false,
                        callbacks: {
                            label: function(ctx) {
                                return `Aset: ${ctx.raw.nama}\nRotasi: ${ctx.raw.x} | Stok: ${ctx.raw.y}`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>