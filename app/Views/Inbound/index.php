<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<div class="p-8">
    <div class="mb-10">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Inbound Operations</h2>
        <p class="text-slate-500 mt-1.5 text-sm font-medium">Otomatisasi penerimaan stok dengan dukungan keputusan AI dan Smart Scan.</p>
    </div>

    <?php if(isset($best_supplier)): ?>
    <div class="mb-10 p-6 bg-gradient-to-r from-indigo-600 to-violet-700 rounded-3xl shadow-xl shadow-indigo-100 text-white flex flex-col md:flex-row items-center justify-between relative overflow-hidden transition-all hover:scale-[1.01]">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 mb-4 md:mb-0">
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-0.5 bg-white/20 backdrop-blur-md rounded text-[9px] font-bold uppercase tracking-[0.2em] text-white border border-white/20">Decision Intelligence</span>
            </div>
            <h3 class="text-indigo-100 text-xs font-semibold uppercase tracking-wide">Rekomendasi Pemasok Optimal:</h3>
            <p class="text-2xl font-black tracking-tight mt-1">
                <?= $best_supplier['nama_supplier'] ?> 
                <span class="text-sm font-medium text-indigo-200 ml-2 opacity-80">SAW Score: <?= $best_supplier['skor_saw'] ?></span>
            </p>
        </div>
        
        <button type="button" onclick="document.querySelector('select[name=id_supplier]').value = '<?= $best_supplier['id_supplier'] ?>'" class="relative z-10 px-6 py-3 bg-white text-indigo-700 rounded-2xl text-xs font-bold hover:bg-indigo-50 shadow-lg transition-all active:scale-95 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            Terapkan Vendor
        </button>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 h-fit">
            <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">New Inbound Entry</h2>
                </div>
                
                <button type="button" onclick="openScanner()" class="group flex items-center gap-2 bg-slate-900 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-indigo-600 transition-all shadow-lg shadow-slate-200 hover:shadow-indigo-200 active:scale-95">
                    <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    Smart Scan
                </button>
            </div>
            
            <form action="<?= base_url('inbound/store') ?>" method="POST" class="space-y-6">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">SKU Barang</label>
                    <select name="id_barang" id="sku_select" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-semibold text-slate-700 focus:bg-white focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 outline-none transition-all appearance-none cursor-pointer">
                        <option value="">-- Pilih Barang --</option>
                        <?php foreach($barang as $b): ?>
                            <option value="<?= $b['id_barang'] ?>">[<?= $b['kode_barang'] ?>] - <?= $b['nama_barang'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Vendor Logistik</label>
                    <select name="id_supplier" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-semibold text-slate-700 focus:bg-white focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 outline-none transition-all appearance-none cursor-pointer">
                        <option value="">-- Pilih Supplier --</option>
                        <?php foreach($supplier as $s): ?>
                            <option value="<?= $s['id_supplier'] ?>"><?= $s['nama_supplier'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Kuantitas Masuk</label>
                    <input type="number" name="qty_masuk" min="1" required placeholder="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:bg-white focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 outline-none transition-all">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-emerald-500 text-white py-4 rounded-xl text-sm font-bold shadow-lg shadow-emerald-100 hover:bg-emerald-600 active:scale-[0.98] transition-all flex justify-center items-center gap-2">
                        Proses Masuk Gudang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                <h2 class="font-bold text-slate-800">Recent Inbound History</h2>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Live Sync</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-bold border-b border-slate-50">
                            <th class="px-8 py-5">Timestamp</th>
                            <th class="px-8 py-5">Product & Provider</th>
                            <th class="px-8 py-5 text-right">Volume</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php foreach($riwayat as $r): ?>
                            <tr class="group hover:bg-slate-50/80 transition-all">
                                <td class="px-8 py-5">
                                    <span class="text-sm font-semibold text-slate-600 block"><?= date('d M Y', strtotime($r['tanggal_masuk'])) ?></span>
                                    <span class="text-[10px] font-bold text-slate-400"><?= date('H:i', strtotime($r['tanggal_masuk'])) ?> WIB</span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-sm font-bold text-slate-800 block"><?= $r['nama_barang'] ?></span>
                                    <span class="text-[10px] font-extrabold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded mt-1 inline-block"><?= $r['nama_supplier'] ?></span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <span class="inline-flex items-center gap-1.5 font-black text-emerald-500 bg-emerald-50 px-4 py-2 rounded-2xl border border-emerald-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        <?= $r['qty_masuk'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if(empty($riwayat)): ?>
                            <tr>
                                <td colspan="3" class="px-8 py-16 text-center">
                                    <p class="text-sm font-medium text-slate-400 italic">No inbound transactions recorded yet.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="scannerModal" class="fixed inset-0 z-[200] hidden bg-slate-900/80 backdrop-blur-md flex flex-col items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div class="bg-white p-6 rounded-3xl shadow-2xl w-full max-w-lg relative overflow-hidden">
        <div class="absolute inset-0 border-8 border-transparent border-t-indigo-500/20 border-b-indigo-500/20 z-0 pointer-events-none rounded-3xl"></div>
        
        <div class="flex justify-between items-center mb-6 relative z-10">
            <div>
                <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Lens Module</h3>
                <p class="text-xs font-bold text-indigo-500 uppercase tracking-widest mt-1">Arahkan QR ke Kamera</p>
            </div>
            <button onclick="closeScanner()" class="p-2 bg-rose-50 text-rose-500 hover:bg-rose-100 rounded-xl transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <div class="w-full rounded-2xl overflow-hidden shadow-inner bg-slate-100 border border-slate-200 relative z-10">
            <div id="reader" width="100%"></div>
        </div>
    </div>
</div>

<script>
    let html5QrcodeScanner;
    const modal = document.getElementById('scannerModal');

    function openScanner() {
        modal.classList.remove('hidden');
        setTimeout(() => modal.classList.remove('opacity-0'), 10);

        // Render Scanner
        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", 
            { 
                fps: 15, 
                qrbox: { width: 250, height: 250 }, 
                aspectRatio: 1.0,
                showTorchButtonIfSupported: true 
            }, 
            false
        );
        
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }

    function closeScanner() {
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }
        }, 300);
    }

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Scan result: ${decodedText}`);
        
        const selectSku = document.getElementById('sku_select');
        const options = selectSku.options;
        let isFound = false;

        for (let i = 0; i < options.length; i++) {
            if (options[i].text.includes(decodedText)) {
                selectSku.selectedIndex = i;
                isFound = true;
                
                // Efek visual form sukses terisi
                selectSku.classList.add('ring-4', 'ring-emerald-200', 'bg-emerald-50');
                setTimeout(() => {
                    selectSku.classList.remove('ring-4', 'ring-emerald-200', 'bg-emerald-50');
                }, 1500);

                break;
            }
        }

        if (isFound) {
            closeScanner();
        } else {
            alert(`Peringatan: SKU [${decodedText}] tidak ditemukan dalam database barang.`);
        }
    }

    function onScanFailure(error) {
        // Abaikan error saat kamera sedang mencari fokus
    }
</script>

<?= $this->endSection() ?>