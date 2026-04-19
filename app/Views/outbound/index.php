<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm font-medium">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm h-fit">
        <h2 class="text-lg font-bold mb-4 border-b pb-2">Input Barang Keluar</h2>
        <form action="<?= base_url('outbound/store') ?>" method="POST">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pilih Barang</label>
                    <select name="id_barang" required class="w-full mt-1 px-3 py-2 border rounded-lg text-sm bg-white">
                        <?php foreach($barang as $b): ?>
                            <option value="<?= $b['id_barang'] ?>"><?= $b['kode_barang'] ?> - <?= $b['nama_barang'] ?> (Stok: <?= $b['stok_aktual'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tujuan Pengiriman</label>
                    <select name="id_customer" required class="w-full mt-1 px-3 py-2 border rounded-lg text-sm bg-white">
                        <?php foreach($customer as $c): ?>
                            <option value="<?= $c['id_customer'] ?>"><?= $c['nama_customer'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jumlah Keluar</label>
                    <input type="number" name="qty_keluar" min="1" required class="w-full mt-1 px-3 py-2 border rounded-lg text-sm">
                </div>
                <button type="submit" class="w-full bg-gray-800 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-black transition">Proses Keluar</button>
            </div>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-4 border-b bg-gray-50/50"><h2 class="font-bold">Log Transaksi Keluar</h2></div>
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Waktu</th>
                    <th class="px-6 py-3">Barang & Tujuan</th>
                    <th class="px-6 py-3 text-right">Qty</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach($riwayat as $r): ?>
                    <tr>
                        <td class="px-6 py-4 text-gray-500"><?= date('d/m H:i', strtotime($r['tanggal_keluar'])) ?></td>
                        <td class="px-6 py-4 font-medium"><?= $r['nama_barang'] ?> <br><span class="text-xs text-gray-400"><?= $r['nama_customer'] ?></span></td>
                        <td class="px-6 py-4 text-right font-bold text-red-600">-<?= $r['qty_keluar'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>