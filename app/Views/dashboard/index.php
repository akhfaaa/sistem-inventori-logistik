<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-gray-500 text-sm font-medium">Total SKU Barang</h3>
        <p class="text-3xl font-bold text-clinical-900"><?= $total_barang ?></p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-gray-500 text-sm font-medium">Stok Kritis</h3>
        <p class="text-3xl font-bold text-red-500"><?= $low_stock ?></p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-gray-500 text-sm font-medium">Model Analitik</h3>
        <p class="text-3xl font-bold text-blue-600">K-Means Active</p>
    </div>
</div>

<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h3 class="font-bold mb-4 text-clinical-900">Ringkasan Klasterisasi Gudang</h3>
    <div class="space-y-4">
        <?php foreach($rekap_kmeans as $r): ?>
        <div>
            <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-gray-700"><?= $r['label_klaster'] ?></span>
                <span class="text-sm font-bold text-gray-900"><?= $r['total'] ?> Barang</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2">
                <div class="bg-clinical-900 h-2 rounded-full" style="width: <?= ($r['total']/$total_barang)*100 ?>%"></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>