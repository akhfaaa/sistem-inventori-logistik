<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Kontainer utama dashboard Kasubbag -->
<div class="max-w-[1400px] mx-auto px-6 py-8">
    <!-- Bagian judul halaman dan deskripsi peran manajerial -->
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Managerial Control</h1>
        <p class="text-slate-500 text-sm mt-1.5 font-medium">Validasi operasional logistik dan pantau peringatan stok kritis.</p>
    </div>

    <!-- Grid utama untuk membagi area informasi menjadi dua kolom utama -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Kolom Kiri: Peringatan Stok Kritis dan Statistik Distribusi -->
        <div class="lg:col-span-5 flex flex-col gap-6">
            <!-- Panel Alert: Menampilkan daftar barang dengan stok menipis -->
            <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex-1">
                <!-- Header panel alert dengan indikasi visual berkedip jika ada peringatan -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-rose-500 <?= !empty($stok_kritis ?? []) ? 'animate-pulse' : '' ?>"></div>
                        Alert: Stok Kritis
                    </h3>
                    <!-- Menampilkan jumlah total peringatan stok kritis -->
                    <span class="px-3 py-1 bg-rose-50 text-rose-700 text-[10px] font-black rounded-lg border border-rose-100"><?= count($stok_kritis ?? []) ?> Peringatan</span>
                </div>
                
                <!-- Daftar barang yang masuk dalam peringatan stok kritis -->
                <div class="space-y-3">
                    <?php if(empty($stok_kritis ?? [])): ?>
                        <!-- Tampilan state kosong: Kondisi gudang aman, tidak ada stok kritis -->
                        <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kondisi Stok Aman</p>
                        </div>
                    <?php else: foreach($stok_kritis ?? [] as $s): ?>
                        <!-- Perulangan untuk setiap item barang yang stoknya di bawah batas minimum -->
                        <div class="p-4 bg-white border-2 border-rose-100 rounded-2xl shadow-sm flex justify-between items-center group hover:border-rose-300 transition-all">
                            <div>
                                <p class="text-xs font-bold text-slate-900 uppercase mb-1"><?= $s['nama_barang'] ?></p>
                                <p class="text-[10px] text-slate-500 font-medium">Sisa <span class="font-black text-rose-600 text-sm"><?= $s['stok_aktual'] ?></span> dari min <?= $s['stok_minimum'] ?></p>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-rose-50 flex items-center justify-center text-rose-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
            
            <!-- Panel Kartu Metrik: Menampilkan jumlah distribusi barang keluar pada hari ini -->
            <div class="bg-amber-500 rounded-[2rem] p-8 text-slate-900 shadow-xl flex justify-between items-center">
                <div>
                    <h3 class="text-[10px] font-black uppercase tracking-widest mb-1 text-amber-900">Distribusi Hari Ini</h3>
                    <!-- Angka total transaksi outbound hari ini -->
                    <p class="text-4xl font-black tracking-tighter"><?= $outbound_today ?? 0 ?></p>
                </div>
                <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-amber-500 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Log Aktivitas Staf Gudang -->
        <div class="lg:col-span-7 bg-white rounded-[2rem] p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
            <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6">Jejak Aktivitas Staf Gudang</h3>
            <div class="space-y-4">
                <?php if(empty($recent_logs ?? [])): ?>
                    <!-- Tampilan state kosong jika belum ada aktivitas terbaru terekam -->
                    <div class="py-10 text-center text-slate-400 text-xs font-bold italic">Belum ada aktivitas terekam.</div>
                <?php else: foreach($recent_logs ?? [] as $log): ?>
                    <!-- Item log aktivitas yang ditampilkan dalam format timeline -->
                    <div class="flex gap-4">
                        <!-- Indikator visual timeline (garis dan titik) -->
                        <div class="flex flex-col items-center mt-1">
                            <div class="w-3 h-3 rounded-full border-2 border-amber-500 bg-white"></div>
                            <div class="w-0.5 h-full bg-slate-100 my-1"></div>
                        </div>
                        <!-- Detail log aktivitas -->
                        <div class="pb-4 flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <!-- Deskripsi aktivitas dan waktu kejadian -->
                                <p class="text-xs font-bold text-slate-900 leading-snug"><?= $log['aktivitas'] ?></p>
                                <span class="text-[9px] font-black text-slate-400 bg-slate-50 px-2 py-1 rounded-md uppercase border border-slate-100 whitespace-nowrap"><?= date('H:i', strtotime($log['waktu'])) ?></span>
                            </div>
                            <!-- Nama staf yang melakukan aktivitas terkait -->
                            <span class="text-[10px] font-medium text-slate-500 uppercase tracking-widest flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <?= $log['nama_lengkap'] ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
            <!-- Tombol navigasi cepat untuk melihat halaman lengkap daftar distribusi (outbound) -->
            <a href="<?= base_url('outbound') ?>" class="mt-4 block w-full py-3 bg-slate-50 border border-slate-200 text-center rounded-xl text-[10px] font-black text-slate-600 uppercase tracking-widest hover:bg-slate-100 transition-all">
                Tinjau Semua Distribusi
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>