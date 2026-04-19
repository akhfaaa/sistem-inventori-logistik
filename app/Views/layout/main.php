<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Command Center | Inventori' ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        clinical: {
                            50: '#f8fafc', // Background super bersih
                            100: '#f1f5f9',
                            800: '#1e293b', // Teks utama (Bukan hitam pekat)
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-clinical-50 text-clinical-800 font-sans antialiased flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
        <div class="h-16 flex items-center px-6 border-b border-gray-200 font-bold text-lg tracking-wider">
            LOGISTICS<span class="text-gray-400 font-light">HUB</span>
        </div>
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="<?= base_url('dashboard') ?>" class="block px-4 py-2 bg-gray-100 rounded-md font-medium">Dashboard</a>
            <a href="<?= base_url('barang') ?>" class="block px-4 py-2 text-gray-500 hover:bg-gray-50 rounded-md">Master Barang</a>
            <a href="<?= base_url('inbound') ?>" class="block px-4 py-2 text-gray-500 hover:bg-gray-50 rounded-md">Inbound / Masuk</a>
            <a href="<?= base_url('outbound') ?>" class="block px-4 py-2 text-gray-500 hover:bg-gray-50 rounded-md">Outbound / Keluar</a>
            <a href="<?= base_url('analitik') ?>" class="block px-4 py-2 text-gray-500 hover:bg-gray-50 rounded-md">Analitik K-Means</a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
            <h1 class="text-xl font-semibold"><?= $title ?? 'Dashboard' ?></h1>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium">Admin System</span>
                <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-clinical-50 p-8">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <?= $this->renderSection('scripts') ?>
</body>
</html>