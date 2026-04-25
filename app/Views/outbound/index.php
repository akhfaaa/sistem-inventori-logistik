<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<div class="p-8">
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-black rounded uppercase tracking-tighter">Outbound Logistics</span>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Distribusi Barang</h2>
            <p class="text-slate-500 mt-1.5 text-sm font-medium">Keluarkan stok untuk kebutuhan proyek atau unit kerja secara presisi.</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-8 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-lg flex items-start gap-3">
            <svg class="w-5 h-5 text-rose-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <p class="text-sm font-bold text-rose-800"><?= session()->getFlashdata('error') ?></p>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-8 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg flex items-start gap-3">
            <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-bold text-emerald-800"><?= session()->getFlashdata('success') ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 h-fit">
            <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-900">Form Pengeluaran</h2>
                <button type="button" onclick="openScanner()" class="p-2.5 bg-slate-50 text-slate-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors border border-slate-200" title="Scan Barcode/QR">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </button>
            </div>

            <form action="<?= base_url('outbound/store') ?>" method="POST" class="space-y-5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Pilih Aset (Stok Tersedia)</label>
                    <select name="id_barang" id="sku_select" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-400 outline-none transition-all">
                        <option value="">-- Cari atau Scan SKU --</option>
                        <?php foreach($barang as $b): ?>
                            <option value="<?= $b['id_barang'] ?>">
                                [<?= $b['kode_barang'] ?>] - <?= $b['nama_barang'] ?> (Sisa: <?= $b['stok_aktual'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Tujuan Distribusi / Unit</label>
                    <select name="id_customer" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-400 outline-none transition-all">
                        <option value="">-- Pilih Tujuan --</option>
                        <?php foreach($customer as $c): ?>
                            <option value="<?= $c['id_customer'] ?>"><?= $c['nama_customer'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Kuantitas Dikeluarkan</label>
                    <input type="number" name="qty_keluar" min="1" required placeholder="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-400 outline-none transition-all">
                </div>
                
                <div class="pt-4">
                    <button type="submit" class="w-full bg-slate-900 text-white py-3.5 rounded-xl text-sm font-bold tracking-wide hover:bg-slate-800 transition-all shadow-lg flex justify-center items-center gap-2">
                        Proses Pengeluaran
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h2 class="font-bold text-slate-800">Riwayat Distribusi Terakhir</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-black border-b border-slate-100 bg-white">
                            <th class="px-6 py-5">Waktu Transaksi</th>
                            <th class="px-6 py-5">Barang & Tujuan</th>
                            <th class="px-6 py-5 text-right">Volume</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if(empty($riwayat)): ?>
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-sm font-medium text-slate-400">Belum ada aktivitas pengeluaran.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($riwayat as $r): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold text-slate-700 block"><?= date('d M Y', strtotime($r['tanggal_keluar'])) ?></span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter"><?= date('H:i', strtotime($r['tanggal_keluar'])) ?> WIB</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold text-slate-900 block"><?= $r['nama_barang'] ?></span>
                                        <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded mt-1 inline-block border border-blue-100">Ke: <?= $r['nama_customer'] ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center gap-1.5 text-sm font-black text-rose-500">
                                            - <?= $r['qty_keluar'] ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="scannerModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm flex flex-col items-center justify-center p-4">
    <div class="bg-white p-6 rounded-2xl shadow-2xl w-full max-w-md relative overflow-hidden">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Pemindai Barcode/QR</h3>
                <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mt-0.5">Scan Aset Keluar</p>
            </div>
            <button onclick="closeScanner()" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="w-full rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
            <div id="reader" width="100%"></div>
        </div>
    </div>
</div>

<script>
    let html5QrcodeScanner;
    function openScanner() {
        document.getElementById('scannerModal').classList.remove('hidden');
        html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 }, false);
        html5QrcodeScanner.render(onScanSuccess, () => {});
    }

    function closeScanner() {
        document.getElementById('scannerModal').classList.add('hidden');
        if (html5QrcodeScanner) html5QrcodeScanner.clear();
    }

    function onScanSuccess(decodedText) {
        const selectSku = document.getElementById('sku_select');
        let isFound = false;
        for (let i = 0; i < selectSku.options.length; i++) {
            if (selectSku.options[i].text.includes(decodedText)) {
                selectSku.selectedIndex = i;
                isFound = true;
                selectSku.classList.add('ring-2', 'ring-blue-500', 'bg-blue-50');
                setTimeout(() => selectSku.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-50'), 1500);
                break;
            }
        }
        if (isFound) closeScanner();
        else alert(`SKU [${decodedText}] tidak dikenali di daftar stok.`);
    }
</script>

<?= $this->endSection() ?>