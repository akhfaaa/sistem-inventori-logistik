<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Portal Otentikasi | SILABAK Kementerian PUPR' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden selection:bg-amber-200 selection:text-slate-900">

    <div class="w-full lg:w-[45%] flex flex-col justify-center px-8 sm:px-16 lg:px-24 z-10 bg-white shadow-[10px_0_30px_rgba(0,0,0,0.03)] relative">
        <div class="w-full max-w-md mx-auto">
            
            <div class="mb-12">
                <div class="inline-block px-3 py-1 mb-6 rounded-md bg-slate-100 border border-slate-200 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                    Portal Akses Terbatas
                </div>
                
                <img src="<?= base_url('assets/img/logo_pupr.png') ?>" alt="Logo Kementerian PUPR" class="h-16 w-auto mb-6">
                
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2 uppercase">
                    SILA<span class="text-amber-500">BAK</span>
                </h1>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Sistem Informasi Logistik dan Barang Persediaan<br>
                    <span class="font-semibold text-slate-800">Bapekom PU Wilayah VII Banjarmasin</span>
                </p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-600 rounded-r-lg flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <h3 class="text-sm font-bold text-red-800">Otentikasi Gagal</h3>
                        <p class="text-xs text-red-700 mt-1"><?= session()->getFlashdata('error') ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/process') ?>" method="POST" class="space-y-6">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Username / NIP Pengguna</label>
                    <input type="text" name="username" required autocomplete="off" placeholder="Masukkan Nomor Induk Pegawai..." 
                           class="block w-full px-4 py-3.5 rounded-lg border border-slate-300 bg-slate-50 text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition-all duration-200">
                </div>
                
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest">Kredensial Sandi</label>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••••••" 
                           class="block w-full px-4 py-3.5 rounded-lg border border-slate-300 bg-slate-50 text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition-all duration-200">
                </div>
                
                <div class="pt-2">
                    <button type="submit" class="relative group w-full flex justify-center items-center gap-2 py-4 px-4 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-lg shadow-lg shadow-slate-900/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-all duration-300 overflow-hidden">
                        <span class="absolute bottom-0 left-0 w-full h-1 bg-amber-500 group-hover:h-1.5 transition-all duration-300"></span>
                        
                        Verifikasi & Masuk Sistem
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>

            <div class="mt-12 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="text-[10px] text-slate-400 font-medium tracking-wide uppercase">
                    &copy; <?= date('Y') ?> Bapekom PU Wilayah VII Banjarmasin
                </span>
                <span class="text-[10px] text-slate-400 font-medium tracking-wide">
                    Sistem Logistik v1.0.0
                </span>
            </div>
        </div>
    </div>

    <div class="hidden lg:flex lg:w-[55%] bg-slate-900 relative justify-center items-center overflow-hidden">
        <div class="absolute inset-0 bg-[#0f172a] z-0"></div>
        <div class="absolute inset-0 opacity-[0.03] z-0" style="background-image: linear-gradient(#f59e0b 1px, transparent 1px), linear-gradient(90deg, #f59e0b 1px, transparent 1px); background-size: 60px 60px;"></div>
        
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-600/10 rounded-full blur-[100px] z-0"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-amber-500/5 rounded-full blur-[120px] z-0"></div>
        
        <div class="z-10 px-16 max-w-2xl border-l border-slate-700/50 pl-12 py-8 relative">
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-32 bg-gradient-to-b from-amber-400 to-amber-600 rounded-r-md"></div>

            <h2 class="text-4xl font-extrabold text-white tracking-tight mb-4 leading-tight">
                Transformasi Digital<br>Manajemen Aset & Logistik.
            </h2>
            <p class="text-base text-slate-400 font-normal mb-10 leading-relaxed max-w-xl">
                Sistem terintegrasi untuk pemantauan, distribusi, dan pelaporan barang persediaan secara *real-time* guna mendukung efisiensi operasional Bapekom PU Wilayah VII Banjarmasin.
            </p>
            
            <div class="grid grid-cols-2 gap-6 mt-8">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-lg bg-slate-800 border border-slate-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-200">Akuntabilitas Data</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Perekaman jejak audit (*audit trail*) otomatis pada setiap mutasi inventori.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-lg bg-slate-800 border border-slate-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-200">Efisiensi Distribusi</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Optimalisasi alur keluar-masuk barang secara sistematis dan terstruktur.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>