<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-[1400px] mx-auto px-6 py-8">
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Warehouse Operations</h1>
        <p class="text-slate-500 text-sm mt-1.5 font-medium">Pilih tindakan operasional untuk memulai pencatatan logistik.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <a href="<?= base_url('inbound') ?>" class="group bg-white p-8 rounded-[2rem] border-2 border-emerald-100 shadow-[0_8px_30px_rgb(16,185,129,0.05)] hover:border-emerald-400 hover:shadow-emerald-100 hover:-translate-y-1 transition-all duration-300 flex items-center gap-6 cursor-pointer">
            <div class="w-20 h-20 bg-emerald-50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </div>
            <div>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-1">Barang Masuk</h3>
                <p class="text-xs font-medium text-slate-500">Scan QR / Catat penerimaan aset baru.</p>
            </div>
        </a>

        <a href="<?= base_url('outbound') ?>" class="group bg-white p-8 rounded-[2rem] border-2 border-blue-100 shadow-[0_8px_30px_rgb(59,130,246,0.05)] hover:border-blue-400 hover:shadow-blue-100 hover:-translate-y-1 transition-all duration-300 flex items-center gap-6 cursor-pointer">
            <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
            </div>
            <div>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-1">Barang Keluar</h3>
                <p class="text-xs font-medium text-slate-500">Keluarkan aset untuk distribusi unit.</p>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-slate-900 rounded-[2rem] p-8 text-white shadow-xl flex flex-col justify-between relative overflow-hidden">
            <div class="absolute inset-0 opacity-[0.03] z-0" style="background-image: radial-gradient(#f59e0b 2px, transparent 2px); background-size: 20px 20px;"></div>
            
            <div class="relative z-10 mb-8">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Aktivitas Hari Ini</h3>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 bg-emerald-500/20 text-emerald-400 rounded-xl flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg></div>
                    <div>
                        <p class="text-3xl font-black leading-none"><?= $transaksi_masuk_hari_ini ?? 0 ?></p>
                        <p class="text-[9px] uppercase font-bold text-slate-400 tracking-widest mt-1">Trx Masuk</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-500/20 text-blue-400 rounded-xl flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg></div>
                    <div>
                        <p class="text-3xl font-black leading-none"><?= $transaksi_keluar_hari_ini ?? 0 ?></p>
                        <p class="text-[9px] uppercase font-bold text-slate-400 tracking-widest mt-1">Trx Keluar</p>
                    </div>
                </div>
            </div>
            <div class="relative z-10 pt-6 border-t border-slate-800">
                <p class="text-[10px] uppercase font-bold text-slate-500 tracking-widest mb-1">Total Katalog</p>
                <p class="text-xl font-black"><?= $total_barang ?? 0 ?> <span class="text-[10px] text-slate-400 font-normal">SKU</span></p>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-[2rem] p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col">
            <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6">Daftar Cek Fisik (Stok Menipis)</h3>
            
            <div class="flex-1 space-y-3">
                <?php if(empty($stok_menipis ?? [])): ?>
                    <div class="flex flex-col items-center justify-center h-full text-slate-400 p-8 border-2 border-dashed border-slate-100 rounded-2xl">
                        <svg class="w-8 h-8 mb-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-[11px] font-bold uppercase tracking-widest">Semua stok mencukupi</p>
                    </div>
                <?php else: foreach($stok_menipis ?? [] as $sm): ?>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl hover:bg-white hover:shadow-md hover:border-amber-200 border border-transparent transition-all cursor-default">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center text-[10px] font-black">!</div>
                            <div>
                                <p class="text-sm font-bold text-slate-900"><?= $sm['nama_barang'] ?></p>
                                <p class="text-[10px] font-medium text-slate-500 uppercase tracking-wider">ID: <?= $sm['kode_barang'] ?></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-black text-rose-600 leading-none"><?= $sm['stok_aktual'] ?></p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Min: <?= $sm['stok_minimum'] ?></p>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>