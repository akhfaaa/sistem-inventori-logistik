<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="p-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Vendor Evaluation Matrix</h2>
            <p class="text-slate-500 mt-1.5 text-sm font-medium">Kelola bobot kriteria supplier untuk akurasi rekomendasi AI.</p>
        </div>

        <button onclick="toggleModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-100 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Add Evaluation
        </button>
    </div>

    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-bold border-b border-slate-50 bg-slate-50/30">
                        <th class="px-8 py-5">Supplier Name</th>
                        <th class="px-8 py-5">Price (C1)</th>
                        <th class="px-8 py-5 text-center">Speed (C2)</th>
                        <th class="px-8 py-5 text-center">Quality (C3)</th>
                        <th class="px-8 py-5">Distance (C4)</th>
                        <th class="px-8 py-5 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach ($evaluasi as $e): ?>
                        <tr class="group hover:bg-slate-50/80 transition-all">
                            <td class="px-8 py-5 font-bold text-slate-800"><?= $e['nama_supplier'] ?></td>
                            <td class="px-8 py-5 text-sm text-slate-600">Rp <?= number_format($e['c1_harga'], 0, ',', '.') ?></td>
                            <td class="px-8 py-5 text-center"><span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg font-bold"><?= $e['c2_kecepatan'] ?></span></td>
                            <td class="px-8 py-5 text-center"><span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg font-bold"><?= $e['c3_kualitas'] ?></span></td>
                            <td class="px-8 py-5 text-sm text-slate-600"><?= $e['c4_jarak'] ?> KM</td>
                            <td class="px-8 py-5">
                                <div class="flex justify-center items-center gap-2">
                                    <button onclick="openEditModal(<?= $e['id_supplier'] ?>, '<?= $e['nama_supplier'] ?>', <?= $e['c1_harga'] ?>, <?= $e['c2_kecepatan'] ?>, <?= $e['c3_kualitas'] ?>, <?= $e['c4_jarak'] ?>)" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Edit Matriks">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>
                                    <a href="<?= base_url('supplierevaluasi/delete/' . $e['id_supplier']) ?>" onclick="return confirm('Hapus data evaluasi ini?')" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Hapus Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalEval" class="fixed inset-0 z-[100] hidden bg-slate-900/40 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-xl overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <h3 class="text-xl font-extrabold text-slate-900">Input Vendor Performance</h3>
            <button onclick="toggleModal()" class="text-slate-400 hover:text-rose-500 transition-all"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg></button>
        </div>
        <form action="<?= base_url('supplierevaluasi/store') ?>" method="POST" class="p-8 space-y-5">
            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Select Supplier</label>
                <select name="id_supplier" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-100">
                    <?php foreach ($supplier_list as $s): ?>
                        <option value="<?= $s['id_supplier'] ?>"><?= $s['nama_supplier'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Price (Cost)</label>
                    <input type="number" name="c1_harga" required placeholder="Contoh: 150000" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Speed (1-100)</label>
                    <input type="number" name="c2_kecepatan" max="100" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Quality (1-100)</label>
                    <input type="number" name="c3_kualitas" max="100" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Distance (KM)</label>
                    <input type="number" name="c4_jarak" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none">
                </div>
            </div>
            <div class="pt-6 border-t border-slate-50 flex justify-end gap-3">
                <button type="button" onclick="toggleModal()" class="text-sm font-bold text-slate-400">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl text-sm font-bold shadow-lg shadow-indigo-100 active:scale-95 transition-all">Save Matrix</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal() {
        document.getElementById('modalEval').classList.toggle('hidden');
    }
</script>
<div id="modalEditEval" class="fixed inset-0 z-[100] hidden bg-slate-900/40 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-xl overflow-hidden transform transition-all">
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="text-xl font-extrabold text-slate-900">Update Performance</h3>
                <p id="edit_nama_vendor" class="text-xs text-indigo-600 font-bold mt-1 uppercase tracking-widest"></p>
            </div>
            <button onclick="closeEditModal()" class="p-2 hover:bg-rose-50 text-slate-400 hover:text-rose-500 rounded-xl transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="<?= base_url('supplierevaluasi/update') ?>" method="POST" class="p-8 space-y-5">
            <input type="hidden" name="id_supplier" id="edit_id_supplier">
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Price (Cost)</label>
                    <input type="number" name="c1_harga" id="edit_c1_harga" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none focus:ring-2 focus:ring-indigo-100 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Speed (1-100)</label>
                    <input type="number" name="c2_kecepatan" id="edit_c2_kecepatan" max="100" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none focus:ring-2 focus:ring-indigo-100 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Quality (1-100)</label>
                    <input type="number" name="c3_kualitas" id="edit_c3_kualitas" max="100" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none focus:ring-2 focus:ring-indigo-100 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Distance (KM)</label>
                    <input type="number" name="c4_jarak" id="edit_c4_jarak" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none focus:ring-2 focus:ring-indigo-100 focus:bg-white transition-all">
                </div>
            </div>
            
            <div class="pt-8 mt-2 border-t border-slate-50 flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">Batal</button>
                <button type="submit" class="px-8 py-3 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 active:scale-95 transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk Modal Add Evaluation (yang sudah ada)
    function toggleModal() {
        document.getElementById('modalEval').classList.toggle('hidden');
    }

    // Fungsi cerdas untuk Modal Edit (Menarik data dari tabel ke dalam form secara otomatis)
    function openEditModal(id, nama, c1, c2, c3, c4) {
        document.getElementById('edit_id_supplier').value = id;
        document.getElementById('edit_nama_vendor').innerText = "Vendor: " + nama;
        document.getElementById('edit_c1_harga').value = c1;
        document.getElementById('edit_c2_kecepatan').value = c2;
        document.getElementById('edit_c3_kualitas').value = c3;
        document.getElementById('edit_c4_jarak').value = c4;
        
        document.getElementById('modalEditEval').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('modalEditEval').classList.add('hidden');
    }
</script>
<?= $this->endSection() ?>