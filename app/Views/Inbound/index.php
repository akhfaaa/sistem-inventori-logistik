<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm h-fit">
        <h2 class="text-lg font-bold mb-4 border-b pb-2">Input Barang Masuk</h2>
        <form action="<?= base_url('inbound/store') ?>" method="POST">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pilih Barang</label>
                    <select name="id_barang" required class="w-full mt-1 px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-clinical-800 bg-white">
                        <?php foreach($barang as $b): ?>
                            <option value="<?= $b['id_barang'] ?>"><?= $b['kode_barang'] ?> - <?= $b['nama_barang'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pemasok</label>
                    <select name="id_supplier" required class="w-full mt-1 px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-clinical-800 bg-white">
                        <?php foreach($supplier as $s): ?>
                            <option value="<?= $s['id_supplier'] ?>"><?= $s['nama_supplier'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jumlah (Qty)</label>
                    <input type="number" name="qty_masuk" min="1" required class="w-full mt-1 px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-clinical-800">
                </div>
                <button type="submit" class="w-full bg-clinical-900 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-clinical-800 transition">Proses Masuk</button>
            </div>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-4 border-b bg-gray-50/50"><h2 class="font-bold">Log Transaksi Masuk</h2></div>
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Waktu</th>
                    <th class="px-6 py-3">Barang</th>
                    <th class="px-6 py-3 text-right">Qty</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach($riwayat as $r): ?>
                    <tr>
                        <td class="px-6 py-4 text-gray-500"><?= date('d/m H:i', strtotime($r['tanggal_masuk'])) ?></td>
                        <td class="px-6 py-4 font-medium"><?= $r['nama_barang'] ?> <br><span class="text-xs text-gray-400"><?= $r['nama_supplier'] ?></span></td>
                        <td class="px-6 py-4 text-right font-bold text-green-600">+<?= $r['qty_masuk'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>