<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="p-8">
    <div class="mb-10">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">System Security & Access</h2>
        <p class="text-slate-500 mt-1.5 text-sm font-medium">Manajemen kredensial karyawan dan kontrol hak akses (Role-Based Access Control).</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-center gap-3">
            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-bold text-rose-800"><?= session()->getFlashdata('error') ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 h-fit">
            <div class="flex items-center gap-3 mb-8 pb-6 border-b border-slate-50">
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <h2 class="text-lg font-bold text-slate-900">Register Staff</h2>
            </div>

            <form action="<?= base_url('users/store') ?>" method="POST" class="space-y-5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none focus:ring-2 focus:ring-violet-100">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Username Log In</label>
                    <input type="text" name="username" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none focus:ring-2 focus:ring-violet-100">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Role / Hak Akses</label>
                    <select name="role" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-violet-700 outline-none focus:ring-2 focus:ring-violet-100">
                        <option value="Staff">Staff Gudang</option>
                        <option value="Kasir">Kasir Logistik</option>
                        <option value="Admin">Administrator Utama</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Temporary Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm outline-none focus:ring-2 focus:ring-violet-100">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-violet-600 text-white py-4 rounded-2xl text-sm font-bold shadow-lg shadow-violet-100 hover:bg-violet-700 active:scale-95 transition-all">
                        Create Account
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                <h2 class="font-bold text-slate-800">Active Personnel</h2>
                <span class="text-[10px] font-bold text-violet-600 bg-violet-50 px-2 py-1 rounded-md uppercase tracking-wider border border-violet-100">RBAC Enabled</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-bold border-b border-slate-50">
                        <tr><th class="px-8 py-5">Identitas Pegawai</th><th class="px-8 py-5 text-center">Level Akses</th><th class="px-8 py-5 text-center">Tindakan</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php foreach($users as $u): ?>
                            <tr class="group hover:bg-slate-50/80 transition-all">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm uppercase <?= $u['role'] == 'Admin' ? 'bg-rose-100 text-rose-600' : 'bg-indigo-100 text-indigo-600' ?>">
                                            <?= substr($u['nama_lengkap'], 0, 2) ?>
                                        </div>
                                        <div>
                                            <span class="text-sm font-bold text-slate-800 block"><?= $u['nama_lengkap'] ?></span>
                                            <span class="text-[10px] font-bold text-slate-400">@<?= $u['username'] ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <?php 
                                        $warna = 'bg-slate-50 text-slate-600 border-slate-200';
                                        if($u['role'] == 'Admin') $warna = 'bg-rose-50 text-rose-600 border-rose-100 shadow-sm';
                                        if($u['role'] == 'Kasir') $warna = 'bg-amber-50 text-amber-600 border-amber-100';
                                        if($u['role'] == 'Staff') $warna = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                                    ?>
                                    <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase border <?= $warna ?>"><?= $u['role'] ?></span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <a href="<?= base_url('users/delete/' . $u['id_user']) ?>" onclick="return confirm('Cabut akses dan hapus pegawai ini dari sistem?')" class="p-2 inline-block text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all" title="Hapus Akun">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>