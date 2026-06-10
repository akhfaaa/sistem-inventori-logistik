<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php $users = $users ?? []; ?>

<div class="p-8">
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-0.5 bg-slate-900 text-amber-400 text-[10px] font-black rounded uppercase tracking-tighter">System Administration</span>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Keamanan & Hak Akses</h2>
            <p class="text-slate-500 mt-1.5 text-sm font-medium">Manajemen kredensial personel Bapekom Wilayah VII (Role-Based Access Control).</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-8 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-lg flex items-start gap-3 shadow-sm">
            <svg class="w-5 h-5 text-rose-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <p class="text-sm font-bold text-rose-800"><?= session()->getFlashdata('error') ?></p>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-8 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg flex items-start gap-3 shadow-sm">
            <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-bold text-emerald-800"><?= session()->getFlashdata('success') ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 h-fit">
            <div class="flex items-center gap-3 mb-8 pb-6 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <h2 class="text-lg font-bold text-slate-900">Registrasi Personel</h2>
            </div>

            <form action="<?= base_url('users/store') ?>" method="POST" class="space-y-5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" required placeholder="Sesuai SK Pegawai..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-amber-400 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Username Akses</label>
                    <input type="text" name="username" required placeholder="Format NIP / Nama" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-amber-400 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Jabatan (Role)</label>
                    <select name="role" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 outline-none focus:ring-2 focus:ring-amber-400 focus:bg-white transition-all cursor-pointer">
                        <option value="Staff">Staff (Logistik & Operasional)</option>
                        <option value="Kasubbag">Kasubbag (Pengawas Tata Usaha)</option>
                        <option value="Kepala Balai">Kepala Balai (Eksekutif/Pimpinan)</option>
                        <option value="Administrator">Administrator (Sistem IT Pusat)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Kata Sandi (Kredensial)</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-amber-400 focus:bg-white transition-all">
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <button type="submit" class="w-full bg-slate-900 text-amber-400 py-3.5 rounded-xl text-sm font-bold tracking-wide shadow-lg shadow-slate-200 hover:bg-slate-800 active:scale-95 transition-all flex justify-center items-center gap-2">
                        Otorisasi Akses
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h2 class="font-bold text-slate-800">Daftar Personel Terdaftar</h2>
                <span class="text-[9px] font-black text-slate-400 bg-white px-2 py-1 rounded border border-slate-200 uppercase tracking-widest">Akses Valid</span>
            </div>
            
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-black border-b border-slate-100 bg-white">
                            <th class="px-6 py-5">Informasi Pegawai</th>
                            <th class="px-6 py-5 text-center">Hierarki Akses</th>
                            <th class="px-6 py-5 text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php foreach($users as $u): ?>
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center font-black text-xs uppercase shadow-sm border <?= $u['role'] == 'Administrator' ? 'bg-amber-100 text-amber-700 border-amber-200' : 'bg-slate-100 text-slate-500 border-slate-200 group-hover:bg-blue-100 group-hover:text-blue-700' ?> transition-colors">
                                            <?= substr($u['nama_lengkap'], 0, 2) ?>
                                        </div>
                                        <div>
                                            <span class="text-sm font-bold text-slate-900 block"><?= $u['nama_lengkap'] ?></span>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5 block">ID: @<?= $u['username'] ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <?php 
                                        $badgeClass = 'bg-slate-50 text-slate-600 border-slate-200';
                                        if($u['role'] == 'Administrator') $badgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
                                        elseif($u['role'] == 'Kepala Balai') $badgeClass = 'bg-indigo-50 text-indigo-700 border-indigo-200';
                                        elseif($u['role'] == 'Kasubbag') $badgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
                                        elseif($u['role'] == 'Staff') $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    ?>
                                    <span class="px-3 py-1 rounded text-[9px] font-black uppercase tracking-widest border <?= $badgeClass ?>">
                                        <?= $u['role'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex justify-end gap-1">
                                        <button onclick="document.getElementById('modalEditUser<?= $u['id_user'] ?>').classList.remove('hidden')" class="p-2 inline-block text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit Kredensial">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>

                                        <a href="<?= base_url('users/delete/' . $u['id_user']) ?>" onclick="return confirm('Sistem akan mencabut otorisasi secara permanen. Lanjutkan?')" class="p-2 inline-block text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Hapus Kredensial">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
</div>

<?php foreach($users as $u): ?>
<div id="modalEditUser<?= $u['id_user'] ?>" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8 transform transition-all relative overflow-hidden">
        
        <div class="flex justify-between items-center mb-8 border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900">Edit Akses Personel</h2>
                <p class="text-[10px] font-bold text-amber-500 uppercase tracking-widest mt-1">ID Pengguna: @<?= $u['username'] ?></p>
            </div>
            <button type="button" onclick="document.getElementById('modalEditUser<?= $u['id_user'] ?>').classList.add('hidden')" class="p-2 bg-slate-50 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-colors border border-slate-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="<?= base_url('users/update/' . $u['id_user']) ?>" method="POST" class="space-y-5">
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="<?= $u['nama_lengkap'] ?>" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 outline-none focus:ring-2 focus:ring-amber-400 focus:bg-white transition-all">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Username Akses</label>
                <input type="text" name="username" value="<?= $u['username'] ?>" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 outline-none focus:ring-2 focus:ring-amber-400 focus:bg-white transition-all">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Jabatan (Role)</label>
                <select name="role" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 outline-none focus:ring-2 focus:ring-amber-400 focus:bg-white transition-all cursor-pointer">
                    <option value="Staff" <?= $u['role'] == 'Staff' ? 'selected' : '' ?>>Staff (Logistik & Operasional)</option>
                    <option value="Kasubbag" <?= $u['role'] == 'Kasubbag' ? 'selected' : '' ?>>Kasubbag (Pengawas Tata Usaha)</option>
                    <option value="Kepala Balai" <?= $u['role'] == 'Kepala Balai' ? 'selected' : '' ?>>Kepala Balai (Eksekutif/Pimpinan)</option>
                    <option value="Administrator" <?= $u['role'] == 'Administrator' ? 'selected' : '' ?>>Administrator (Sistem IT Pusat)</option>
                </select>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 border-dashed">
                <label class="flex justify-between items-center text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">
                    Ganti Kata Sandi
                    <span class="text-[9px] text-amber-600 bg-amber-100 px-2 py-0.5 rounded">*Opsional</span>
                </label>
                <input type="password" name="password" placeholder="Isi untuk mengganti sandi..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg text-sm font-semibold text-slate-900 outline-none focus:ring-2 focus:ring-amber-400 transition-all">
                <p class="text-[10px] text-slate-400 font-medium mt-2 leading-relaxed">Kosongkan kolom ini jika Anda tidak ingin mengubah kata sandi lama milik pengguna.</p>
            </div>

            <div class="pt-6 flex justify-end gap-3 mt-8">
                <button type="button" onclick="document.getElementById('modalEditUser<?= $u['id_user'] ?>').classList.add('hidden')" class="px-5 py-3 text-sm font-bold text-slate-500 hover:bg-slate-50 hover:text-slate-700 rounded-xl transition-all border border-transparent hover:border-slate-200">Batal</button>
                <button type="submit" class="px-6 py-3 bg-slate-900 text-amber-400 text-sm font-bold rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">Perbarui Akses</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>

<?= $this->endSection() ?>