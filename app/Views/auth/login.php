<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-white flex h-screen overflow-hidden">

    <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 sm:p-12 z-10 bg-white shadow-2xl">
        <div class="w-full max-w-md">
            
            <div class="mb-10 text-center lg:text-left">
                <div class="inline-flex items-center justify-center w-14 h-14 bg-indigo-600 rounded-2xl shadow-lg shadow-indigo-200 mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-2">Welcome Back</h1>
                <p class="text-slate-500 font-medium">Masuk ke sistem kontrol Logistics Hub Enterprise.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-xl flex items-center gap-3 animate-pulse">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm font-bold text-rose-800"><?= session()->getFlashdata('error') ?></p>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/process') ?>" method="POST" class="space-y-6">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Username Akses</label>
                    <input type="text" name="username" required autocomplete="off" placeholder="Masukkan username..." class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all">
                </div>
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest">Kata Sandi</label>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all">
                </div>
                
                <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-xl text-sm font-bold tracking-wide shadow-xl shadow-indigo-200 hover:bg-indigo-700 active:scale-[0.98] transition-all flex justify-center items-center gap-2 mt-4">
                    Otorisasi & Masuk Sistem
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>

            <div class="mt-10 text-center text-sm text-slate-400 font-medium">
                &copy; <?= date('Y') ?> Logistics Hub. All rights reserved.
            </div>
        </div>
    </div>

    <div class="hidden lg:flex w-1/2 bg-slate-900 relative justify-center items-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-900 opacity-90 z-0"></div>
        <div class="absolute inset-0 opacity-20 z-0" style="background-image: radial-gradient(#4f46e5 1px, transparent 1px); background-size: 32px 32px;"></div>
        
        <div class="z-10 text-center px-12 max-w-xl">
            <h2 class="text-4xl font-extrabold text-white tracking-tight mb-6 leading-tight">Optimasi Inventori dengan Kecerdasan Buatan.</h2>
            <p class="text-lg text-indigo-200 font-medium mb-8">Platform manajemen logistik cerdas yang ditenagai oleh algoritma K-Means Clustering untuk efisiensi ruang gudang Anda.</p>
            
            <div class="flex items-center justify-center gap-4 text-sm font-bold text-white uppercase tracking-widest">
                <span class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-emerald-400"></div> Secure</span>
                <span class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-blue-400"></div> Fast</span>
                <span class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-rose-400"></div> Real-time</span>
            </div>
        </div>
    </div>

</body>
</html>