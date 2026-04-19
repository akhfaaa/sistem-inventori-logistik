<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Logistics Hub Enterprise' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-item-active {
            background: rgba(79, 70, 229, 0.08);
            color: #4f46e5;
            border-right: 4px solid #4f46e5;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] text-slate-900 overflow-hidden">
    <div class="flex h-screen">

        <aside class="hidden md:flex flex-col w-72 bg-white border-r border-slate-200 shadow-sm z-20">
            <div class="p-8 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-100">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">Logistics<span class="text-indigo-600">Hub</span></span>
                </div>
            </div>

            <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto custom-scrollbar">
                <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-4">Core Analytics</p>

                <a href="<?= base_url('home/main') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all hover:bg-slate-50 <?= url_is('home/main*') ? 'sidebar-item-active' : 'text-slate-500' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Executive Dashboard
                </a>

                <?php if (session()->get('role') == 'Admin'): ?>
                    <a href="<?= base_url('barang') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all hover:bg-slate-50 <?= url_is('barang*') ? 'sidebar-item-active' : 'text-slate-500' ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Inventory Master
                    </a>

                    <a href="<?= base_url('supplierevaluasi') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all hover:bg-slate-50 <?= url_is('supplierevaluasi*') ? 'sidebar-item-active' : 'text-slate-500' ?>">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
    Evaluasi Vendor
</a>
                <?php endif; ?>

                <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-10 mb-4">Warehouse Ops</p>


                <a href="<?= base_url('inbound') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all hover:bg-slate-50 <?= url_is('inbound*') ? 'sidebar-item-active' : 'text-slate-500' ?> hover:text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                    </svg>
                    Stock Inbound
                </a>

                <a href="<?= base_url('outbound') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all hover:bg-slate-50 <?= url_is('outbound*') ? 'sidebar-item-active' : 'text-slate-500' ?> hover:text-rose-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                    </svg>
                    Stock Outbound
                </a>

                <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-10 mb-4">Report</p>

                <a href="<?= base_url('laporan') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all hover:bg-slate-50 <?= url_is('laporan*') ? 'sidebar-item-active' : 'text-slate-500' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Report Center
                </a>

                <div class="pt-10 mt-10 border-t border-slate-100">
                    <a href="<?= base_url('auth/logout') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-rose-500 hover:bg-rose-50 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout Session
                    </a>
                </div>
            </nav>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200 h-20 flex items-center justify-between px-8 shrink-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="md:hidden w-8 h-8 bg-indigo-600 rounded-lg"></div>
                    <div class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-widest">
                        <span class="text-indigo-600"><?= session()->get('role') ?></span>
                        <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" stroke-width="3"></path>
                        </svg>
                        <span class="text-slate-400"><?= $title ?></span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-extrabold text-slate-900 leading-none"><?= session()->get('nama_lengkap') ?></p>
                        <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-tighter italic">Logistics Officer</p>
                    </div>
                    <div class="w-10 h-10 rounded-2xl bg-slate-900 flex items-center justify-center text-xs font-bold text-white shadow-lg shadow-slate-200 cursor-pointer hover:scale-105 transition-transform">
                        <?php
                        $nameParts = explode(' ', session()->get('nama_lengkap'));
                        echo strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                        ?>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto custom-scrollbar">
                <?= $this->renderSection('content') ?>

                <footer class="p-8 mt-auto flex justify-between items-center border-t border-slate-100 bg-white/50">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">&copy; <?= date('Y') ?> Logistics Hub Enterprise System</p>
                    <div class="flex gap-4">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-[10px] font-bold text-slate-500 uppercase">System Operational</span>
                    </div>
                </footer>
            </div>
        </main>
    </div>
</body>

</html>