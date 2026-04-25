<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<div class="p-8">
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-black rounded uppercase tracking-tighter">Inbound Logistics</span>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Penerimaan Barang</h2>
            <p class="text-slate-500 mt-1.5 text-sm font-medium">Registrasi stok masuk terintegrasi dengan pemindai pintar dan rekomendasi AI.</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg flex items-start gap-3">
            <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-bold text-emerald-800"><?= session()->getFlashdata('success') ?></p>
        </div>
    <?php endif; ?>

    <?php if(isset($best_supplier)): ?>
    <div class="mb-8 p-6 bg-slate-900 rounded-2xl shadow-lg border border-slate-800 flex flex-col md:flex-row items-center justify-between relative overflow-hidden group">
        <div class="absolute inset-0 opacity-[0.03] z-0" style="background-image: linear-gradient(#f59e0b 1px, transparent 1px), linear-gradient(90deg, #f59e0b 1px, transparent 1px); background-size: 20px 20px;"></div>
        
        <div class="relative z-10 flex items-center gap-6 mb-4 md:mb-0">
            <div class="hidden md:flex w-14 h-14 bg-amber-500 rounded-xl items-center justify-center text-slate-900 shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2 py-0.5 border border-amber-400/30 text-amber-400 text-[9px] font-bold uppercase tracking-widest rounded">SPK (SAW) Rekomendasi</span>
                </div>
                <h3 class="text-white text-xl font-bold tracking-tight">
                    <?= $best_supplier['nama_supplier'] ?>
                </h3>
                <p class="text-slate-400 text-xs font-medium mt-1">Vendor optimal berdasarkan evaluasi kriteria (Skor: <span class="text-amber-400 font-bold"><?= $best_supplier['skor_saw'] ?></span>).</p>
            </div>
        </div>
        
        <button type="button" onclick="document.querySelector('select[name=id_supplier]').value = '<?= $best_supplier['id_supplier'] ?>'" class="relative z-10 px-5 py-2.5 bg-amber-500 text-slate-900 rounded-lg text-xs font-black uppercase tracking-widest hover:bg-amber-400 shadow-lg shadow-amber-500/20 transition-all active:scale-95 flex items-center gap-2">
            Gunakan Pemasok
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 h-fit">
            <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-900">Form Masuk Gudang</h2>
                <button type="button" onclick="openScanner()" class="p-2.5 bg-slate-50 text-slate-600 rounded-lg hover:bg-amber-50 hover:text-amber-600 transition-colors border border-slate-200" title="Scan Barcode/QR">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </button>
            </div>
            
            <form action="<?= base_url('inbound/store') ?>" method="POST" class="space-y-5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Pilih Aset (SKU)</label>
                    <select name="id_barang" id="sku_select" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:bg-white focus:ring-2 focus:ring-amber-400 outline-none transition-all">
                        <option value="">-- Cari atau Scan SKU --</option>
                        <?php foreach($barang as $b): ?>
                            <option value="<?= $b['id_barang'] ?>">[<?= $b['kode_barang'] ?>] - <?= $b['nama_barang'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Pemasok Logistik</label>
                    <select name="id_supplier" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:bg-white focus:ring-2 focus:ring-amber-400 outline-none transition-all">
                        <option value="">-- Pilih Pemasok --</option>
                        <?php foreach($supplier as $s): ?>
                            <option value="<?= $s['id_supplier'] ?>"><?= $s['nama_supplier'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Kuantitas Diterima</label>
                    <input type="number" name="qty_masuk" min="1" required placeholder="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:bg-white focus:ring-2 focus:ring-amber-400 outline-none transition-all">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-slate-900 text-amber-400 py-3.5 rounded-xl text-sm font-bold tracking-wide hover:bg-slate-800 transition-all shadow-lg flex justify-center items-center gap-2">
                        Verifikasi Masuk Gudang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h2 class="font-bold text-slate-800">Riwayat Penerimaan Terakhir</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-black border-b border-slate-100 bg-white">
                            <th class="px-6 py-5">Waktu Transaksi</th>
                            <th class="px-6 py-5">Informasi Barang</th>
                            <th class="px-6 py-5 text-right">Volume</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if(empty($riwayat)): ?>
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-sm font-medium text-slate-400">Belum ada aktivitas penerimaan.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($riwayat as $r): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold text-slate-700 block"><?= date('d M Y', strtotime($r['tanggal_masuk'])) ?></span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter"><?= date('H:i', strtotime($r['tanggal_masuk'])) ?> WIB</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold text-slate-900 block"><?= $r['nama_barang'] ?></span>
                                        <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded mt-1 inline-block border border-amber-100"><?= $r['nama_supplier'] ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center gap-1.5 text-sm font-black text-emerald-600">
                                            + <?= $r['qty_masuk'] ?>
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
                <p class="text-[10px] font-bold text-amber-500 uppercase tracking-widest mt-0.5">Arahkan kamera ke label</p>
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
                selectSku.classList.add('ring-2', 'ring-amber-500', 'bg-amber-50');
                setTimeout(() => selectSku.classList.remove('ring-2', 'ring-amber-500', 'bg-amber-50'), 1500);
                break;
            }
        }
        if (isFound) closeScanner();
        else alert(`SKU [${decodedText}] tidak dikenali di database.`);
    }
</script>

<?= $this->endSection() ?>