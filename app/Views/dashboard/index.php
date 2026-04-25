<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="p-8 space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Dashboard Monitor Strategis</h1>
            <p class="text-slate-500 text-sm font-medium mt-1">Pantauan real-time inventori Bapekom Wilayah VII Banjarmasin.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Ekspor Laporan
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">+12% Bulan Ini</span>
            </div>
            <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest">Total Master Aset</h3>
            <p class="text-3xl font-black text-slate-900 mt-1">1,284 <span class="text-sm font-medium text-slate-400">Item</span></p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600 group-hover:bg-rose-500 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-rose-600 bg-rose-50 px-2 py-1 rounded-full">Perlu Restock</span>
            </div>
            <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest">Stok Menipis</h3>
            <p class="text-3xl font-black text-slate-900 mt-1">14 <span class="text-sm font-medium text-slate-400">SKU</span></p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 group-hover:bg-blue-500 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">On Delivery</span>
            </div>
            <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest">Outbound (Hari Ini)</h3>
            <p class="text-3xl font-black text-slate-900 mt-1">42 <span class="text-sm font-medium text-slate-400">Transaksi</span></p>
        </div>

        <div class="bg-slate-900 p-6 rounded-2xl shadow-lg shadow-slate-200 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-400 rounded-xl flex items-center justify-center text-slate-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-amber-400 border border-amber-400/30 px-2 py-1 rounded-full">AI Cluster</span>
            </div>
            <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest">Optimasi Ruang</h3>
            <p class="text-3xl font-black text-white mt-1">Fast <span class="text-sm font-medium text-amber-500 underline underline-offset-4">Moving</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-lg font-bold text-slate-900">Tren Pergerakan Barang</h3>
                <select class="text-xs font-bold text-slate-500 bg-slate-50 border-none rounded-lg focus:ring-0 cursor-pointer">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                </select>
            </div>
            <div class="h-72 w-full bg-slate-50 rounded-xl border border-dashed border-slate-200 flex items-center justify-center">
                <p class="text-slate-400 text-sm italic">[ Visualisasi Grafik Tren Terintegrasi ]</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
            <h3 class="text-lg font-bold text-slate-900 mb-6">Log Aktivitas</h3>
            <div class="space-y-6">
                <div class="flex gap-4">
                    <div class="relative">
                        <div class="w-2 h-2 mt-2 rounded-full bg-amber-500"></div>
                        <div class="absolute top-4 left-[3px] w-[2px] h-10 bg-slate-100"></div>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800 italic">Penerimaan Barang Baru</p>
                        <p class="text-xs text-slate-500 mt-0.5">ATK - Kertas A4 (50 Rim)</p>
                        <span class="text-[10px] text-slate-400 uppercase font-black tracking-tighter">10 Menit Lalu</span>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-2 h-2 mt-2 rounded-full bg-blue-500"></div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">Distribusi Disetujui</p>
                        <p class="text-xs text-slate-500 mt-0.5">Oleh: Kasubbag Tata Usaha</p>
                        <span class="text-[10px] text-slate-400 uppercase font-black tracking-tighter">1 Jam Lalu</span>
                    </div>
                </div>
            </div>
            <button class="w-full mt-8 py-3 text-xs font-black text-slate-400 hover:text-amber-600 transition-colors uppercase tracking-widest">
                Lihat Semua Aktivitas
            </button>
        </div>
    </div>
</div>
<?= $this->endSection() ?>