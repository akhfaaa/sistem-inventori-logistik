<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SILABAK | Kementerian PUPR' ?></title>

    <!-- Tailwind CSS dan font Inter untuk styling antarmuka -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Highlight navigasi sidebar ketika menu aktif */
        .sidebar-link.active {
            background-color: #fffbeb;
            /* amber-50 */
            color: #b45309;
            /* amber-700 */
            border-right: 4px solid #f59e0b;
            /* amber-500 */
            font-weight: 700;
        }

        .sidebar-link.active svg {
            color: #d97706;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 selection:bg-amber-200 selection:text-slate-900">

    <!-- Layout utama: sidebar kiri dan konten utama kanan -->
    <div class="flex min-h-screen">
        <aside class="w-72 bg-white border-r border-slate-200 flex flex-col sticky top-0 h-screen z-50 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
            <!-- Bagian logo dan nama instansi -->
            <div class="p-8 mb-2">
                <div class="flex items-center gap-3">
                    <img src="<?= base_url('assets/img/logo_pupr.png') ?>" alt="PUPR" class="w-10 h-auto drop-shadow-sm">
                    <span class="text-2xl font-extrabold tracking-tight text-slate-900 uppercase">SILA<span class="text-amber-500">BAK</span></span>
                </div>
                <p class="text-[9px] font-black text-slate-400 mt-3 uppercase tracking-[0.2em]">Bapekom PU Wilayah VII Banjarmasin</p>
            </div>

            <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto">
                <!-- Menu navigasi utama sidebar -->
                <div class="px-4 mb-3 mt-2 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">Navigasi Utama</div>

                <a href="<?= base_url('home') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard Monitor
                </a>

                <!-- Menu yang bisa diakses oleh Staff, Kasubbag, dan Administrator -->
                <?php if (in_array(session()->get('role'), ['Staff', 'Kasubbag', 'Administrator'])): ?>
                    <a href="<?= base_url('barang') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3.5 text-sm font-semibold text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Katalog Master Aset
                    </a>
                 <?php endif; ?>

                <?php if (session()->get('role') == 'Staff'): ?>
                    <!-- Menu khusus staff untuk proses inbound/outbound/retur -->
                    <div class="px-4 mt-8 mb-3 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">Sirkulasi Logistik</div>
                    
                    <!-- Menu Penerimaan Barang (Inbound) -->
                    <a href="<?= base_url('inbound') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3.5 text-sm font-semibold text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                        Penerimaan (Inbound)
                    </a>
                    
                    <!-- Menu Pengeluaran/Distribusi Barang (Outbound) -->
                    <a href="<?= base_url('outbound') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3.5 text-sm font-semibold text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                        </svg>
                        Distribusi (Outbound)
                    </a>
                    
                    <!-- Menu Manajemen Pengembalian/Retur Aset -->
                    <a href="<?= base_url('retur') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3.5 text-sm font-semibold text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                        </svg>
                        Manajemen Retur
                    </a>
                <?php endif; ?>

                <?php if (in_array(session()->get('role'), ['Staff', 'Administrator'])): ?>
                    <!-- Menu untuk melakukan manajemen data Kategori & Lokasi Rak -->
                    <a href="<?= base_url('rak') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3.5 text-sm font-semibold text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 4V2M10 4V2M4 14a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 12v-2M10 12v-2M4 22a2 2 0 012-2h12a2 2 0 012 2v2"></path>
                        </svg>
                        Kategori & Rak
                    </a>
                <?php endif; ?>

                <?php if (in_array(session()->get('role'), ['Kepala Balai', 'Kasubbag', 'Administrator'])): ?>
                    <!-- Menu untuk user tingkat eksekutif dan laporan PDF -->
                    <div class="px-4 mt-8 mb-3 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">Analitik Eksekutif</div>
                    
                    <!-- Visualisasi data menggunakan K-Means Clustering -->
                    <a href="<?= base_url('analitik') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3.5 text-sm font-semibold text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Spatial Intelligence
                    </a>
                    
                    <!-- Export laporan sistem dalam bentuk dokumen (PDF) -->
                    <a href="<?= base_url('laporan') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3.5 text-sm font-semibold text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Pusat Laporan PDF
                    </a>
                <?php endif; ?>

                <?php if (session()->get('role') == 'Administrator'): ?>
                    <!-- Bagian menu khusus administrator -->
                    <div class="px-4 mt-8 mb-3 text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">Konfigurasi Sistem</div>
                    
                    <!-- Manajemen Pengguna Sistem (Control Panel) -->
                    <a href="<?= base_url('users') ?>" class="sidebar-link flex items-center gap-3 px-4 py-3.5 text-sm font-semibold text-slate-500 hover:text-amber-700 hover:bg-amber-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Keamanan & Akses
                    </a>
                <?php endif; ?>
            </nav>

            <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                <!-- Tombol logout untuk mengakhiri sesi pengguna -->
                <a href="<?= base_url('auth/logout') ?>" class="flex items-center justify-center gap-2 w-full py-3 bg-white border border-slate-200 text-xs font-bold text-rose-600 hover:bg-rose-50 hover:border-rose-200 rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Akhiri Sesi
                </a>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Konten utama aplikasi -->
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-40 shadow-[0_4px_24px_rgba(0,0,0,0.01)]">
                <div class="flex items-center gap-4">
                    <!-- Header ringkas menampilkan role dan judul halaman -->
                    <div class="hidden md:flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-[0.1em]">
                        <span class="text-amber-600"><?= session()->get('role') ?></span>
                        <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="3" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="text-slate-600 truncate"><?= $title ?? 'Operasional Logistik' ?></span>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <!-- Menampilkan tanggal saat ini -->
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest hidden sm:block"><?= date('l, d F Y') ?></span>
                    <div class="flex items-center gap-3 pl-5 border-l border-slate-200">
                        <div class="text-right hidden sm:block">
                            <!-- Menampilkan nama lengkap dan role pengguna yang sedang login -->
                            <p class="text-xs font-bold text-slate-900 leading-none"><?= session()->get('nama_lengkap') ?></p>
                            <p class="text-[10px] font-medium text-slate-500 mt-1 uppercase"><?= session()->get('role') ?></p>
                        </div>
                        <!-- Inisial avatar pengguna (Diambil huruf pertama dari nama) -->
                        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-700 font-black text-sm border border-amber-200 uppercase shadow-inner">
                            <?= substr(session()->get('nama_lengkap'), 0, 1) ?>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto bg-slate-50/50">
                <!-- Render konten halaman yang disisipkan oleh view anak -->
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>

    <!-- Script untuk menandai menu aktif pada sidebar secara dinamis -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentUrl = window.location.href;
            const navLinks = document.querySelectorAll('.sidebar-link');

            navLinks.forEach(link => {
                // Beri kelas aktif pada menu sidebar yang sesuai dengan URL saat ini
                if (currentUrl === link.href || currentUrl.startsWith(link.href + '/')) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>