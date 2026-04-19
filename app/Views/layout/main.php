<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Logistics Hub Enterprise' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link.active {
            background-color: #f5f3ff;
            color: #4f46e5;
            border-right: 4px solid #4f46e5;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <div class="flex min-h-screen">
        <aside class="w-72 bg-white border-r border-slate-100 flex flex-col sticky top-0 h-screen z-50">
            <div class="p-8 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-100">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-800">SILA<span class="text-indigo-600">BAK</span></span>
                </div>
            </div>

            <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
                <div class="px-4 mb-2 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Core Analytics</div>
                
                <a href="<?= base_url('home/main') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Executive Dashboard
                </a>

                <?php if(session()->get('role') == 'Admin'): ?>
                <a href="<?= base_url('barang') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Inventory Master
                </a>
                <a href="<?= base_url('supplierevaluasi') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Evaluasi Vendor
                </a>
                <a href="<?= base_url('master') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Taxonomy Master
                </a>
                <?php endif; ?>

                <div class="px-4 mt-8 mb-2 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Warehouse Ops</div>
                
                <a href="<?= base_url('inbound') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                    Stock Inbound
                </a>
                <a href="<?= base_url('outbound') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                    Stock Outbound
                </a>
                <a href="<?= base_url('retur') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                    Retur Barang
                </a>

                <?php if(session()->get('role') == 'Admin'): ?>
                <div class="px-4 mt-8 mb-2 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Security & Reports</div>
                <a href="<?= base_url('laporan') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Report Center
                </a>
                <a href="<?= base_url('users') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    User Management
                </a>
                <?php endif; ?>
            </nav>

            <div class="p-4 border-t border-slate-50">
                <a href="<?= base_url('auth/logout') ?>" class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-rose-500 hover:bg-rose-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout Session
                </a>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
           <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40">
    <div class="flex items-center gap-3">
        <div class="px-3 py-1 bg-amber-400 rounded-lg text-[10px] font-black text-slate-900 shadow-sm shadow-amber-100 uppercase tracking-tighter">Bapekom VII</div>
        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">
            <span class="text-indigo-600"><?= session()->get('role') ?></span>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="truncate"><?= $title ?? 'Logistics Operations' ?></span>
        </div>
    </div>
    </header>

            <div class="flex-1 overflow-y-auto bg-slate-50/50">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const currentUrl = window.location.href;
            const navLinks = document.querySelectorAll('.sidebar-link');
            
            navLinks.forEach(link => {
                if (currentUrl.includes(link.href)) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>