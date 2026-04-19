<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<div class="p-8">
    <div class="mb-10">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Outbound Operations</h2>
        <p class="text-slate-500 mt-1.5 text-sm font-medium">Distribusi stok cepat dan akurat menggunakan pemindai pintar.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-8 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-center gap-3 animate-pulse">
            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-bold text-rose-800"><?= session()->getFlashdata('error') ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 h-fit">
            <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">New Outbound</h2>
                </div>
                
                <button type="button" onclick="openScanner()" class="group flex items-center gap-2 bg-slate-900 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-rose-600 transition-all shadow-lg active:scale-95">
                    <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    Smart Scan
                </button>
            </div>

            <form action="<?= base_url('outbound/store') ?>" method="POST" class="space-y-6">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">SKU Barang (Tersedia)</label>
                    <select name="id_barang" id="sku_select" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-rose-100 outline-none">
                        <option value="">-- Pilih Barang --</option>
                        <?php foreach($barang as $b): ?>
                            <option value="<?= $b['id_barang'] ?>">
                                [<?= $b['kode_barang'] ?>] - <?= $b['nama_barang'] ?> (Sisa: <?= $b['stok_aktual'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Customer / Tujuan</label>
                    <select name="id_customer" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-rose-100 outline-none">
                        <option value="">-- Pilih Tujuan --</option>
                        <?php foreach($customer as $c): ?>
                            <option value="<?= $c['id_customer'] ?>"><?= $c['nama_customer'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Kuantitas Keluar</label>
                    <input type="number" name="qty_keluar" min="1" required placeholder="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold outline-none focus:ring-2 focus:ring-rose-100">
                </div>
                <div class="pt-4">
                    <button type="submit" class="w-full bg-rose-500 text-white py-4 rounded-xl text-sm font-bold hover:bg-rose-600 active:scale-95 transition-all flex justify-center items-center gap-2">
                        Kurangi Stok & Kirim
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h2 class="font-bold text-slate-800">Recent Outbound History</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-bold border-b border-slate-50">
                        <tr><th class="px-8 py-5">Tanggal</th><th class="px-8 py-5">Barang & Tujuan</th><th class="px-8 py-5 text-right">Qty</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php foreach($riwayat as $r): ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-8 py-5 text-sm font-medium text-slate-500"><?= date('d M Y', strtotime($r['tanggal_keluar'])) ?></td>
                                <td class="px-8 py-5 text-sm font-bold text-slate-800"><?= $r['nama_barang'] ?><br><span class="text-[10px] text-rose-500">To: <?= $r['nama_customer'] ?></span></td>
                                <td class="px-8 py-5 text-right font-black text-rose-500">- <?= $r['qty_keluar'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="scannerModal" class="fixed inset-0 z-[200] hidden bg-slate-900/80 backdrop-blur-md flex flex-col items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div class="bg-white p-6 rounded-3xl shadow-2xl w-full max-w-lg relative overflow-hidden">
        <div class="flex justify-between items-center mb-6 relative z-10">
            <div>
                <h3 class="text-xl font-extrabold text-slate-900">Lens Module</h3>
                <p class="text-xs font-bold text-rose-500 uppercase tracking-widest mt-1">Scan QR Code Keluar</p>
            </div>
            <button onclick="closeScanner()" class="p-2 bg-rose-50 text-rose-500 hover:bg-rose-100 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <div class="w-full rounded-2xl overflow-hidden shadow-inner bg-slate-100 relative z-10">
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
        html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 15, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 }, false);
        html5QrcodeScanner.render(onScanSuccess, () => {});
    }

    function closeScanner() {
        modal.classList.add('opacity-0');
        setTimeout(() => { modal.classList.add('hidden'); if (html5QrcodeScanner) html5QrcodeScanner.clear(); }, 300);
    }

    function onScanSuccess(decodedText) {
        const selectSku = document.getElementById('sku_select');
        let isFound = false;

        for (let i = 0; i < selectSku.options.length; i++) {
            if (selectSku.options[i].text.includes(decodedText)) {
                selectSku.selectedIndex = i;
                isFound = true;
                selectSku.classList.add('ring-4', 'ring-rose-200', 'bg-rose-50');
                setTimeout(() => selectSku.classList.remove('ring-4', 'ring-rose-200', 'bg-rose-50'), 1500);
                break;
            }
        }

        if (isFound) {
            new Audio('https://www.soundjay.com/buttons/sounds/button-09.mp3').play().catch(()=>{});
            closeScanner();
        } else {
            alert(`SKU [${decodedText}] tidak ditemukan.`);
        }
    }
</script>
<?= $this->endSection() ?>