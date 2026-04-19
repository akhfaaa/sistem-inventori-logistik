<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-clinical-900">Analitik K-Means Clustering</h2>
        <p class="text-sm text-gray-500">Otomatisasi pengelompokan stok berdasarkan kecepatan rotasi barang.</p>
    </div>
    <form action="<?= base_url('analitik/proses') ?>" method="POST">
        <button type="submit" class="bg-clinical-900 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-black transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            Jalankan Ulang Algoritma
        </button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <?php 
    $labels = ['Fast Moving' => 'bg-green-50 text-green-700 border-green-200', 'Slow Moving' => 'bg-blue-50 text-blue-700 border-blue-200', 'Dead Stock' => 'bg-red-50 text-red-700 border-red-200'];
    foreach($rekap as $r): 
    ?>
    <div class="p-6 rounded-xl border <?= $labels[$r['label_klaster']] ?? 'bg-gray-50' ?>">
        <h3 class="text-xs uppercase font-bold tracking-widest opacity-70"><?= $r['label_klaster'] ?></h3>
        <p class="text-4xl font-black mt-2"><?= $r['total'] ?> <span class="text-sm font-normal">Barang</span></p>
    </div>
    <?php endforeach; ?>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-4">Nama Barang</th>
                <th class="px-6 py-4 text-center">Skor Velocity (Total Keluar)</th>
                <th class="px-6 py-4 text-center">Status Klaster</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php foreach($list_barang as $l): ?>
            <tr>
                <td class="px-6 py-4 font-medium"><?= $l['nama_barang'] ?></td>
                <td class="px-6 py-4 text-center font-mono"><?= number_format($l['velocity_score'], 0) ?></td>
                <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 rounded-full text-xs font-bold border 
                        <?= $l['label_klaster'] == 'Fast Moving' ? 'border-green-200 text-green-600' : ($l['label_klaster'] == 'Dead Stock' ? 'border-red-200 text-red-600' : 'border-blue-200 text-blue-600') ?>">
                        <?= $l['label_klaster'] ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>