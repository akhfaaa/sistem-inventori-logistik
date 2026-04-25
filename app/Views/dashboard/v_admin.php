<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-[1400px] mx-auto px-4 py-8">
    
    <div class="mb-10">
        <div class="inline-flex items-center px-3 py-1 bg-slate-800 text-slate-300 text-[10px] font-black rounded-full border border-slate-700 mb-3 uppercase tracking-widest">
            System Control: Administrator
        </div>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">System Configuration</h1>
        <p class="text-slate-500 text-sm mt-2 font-medium">Pusat manajemen pengguna, log aktivitas keamanan, dan status mesin SILABAK.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        
        <div class="md:col-span-8 bg-slate-900 p-10 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden flex flex-col justify-between group">
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <h3 class="text-xs font-black text-indigo-400 uppercase tracking-widest mb-2">K-Means Core Engine</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></div>
                        <p class="text-4xl font-black tracking-tighter">ONLINE</p>
                    </div>
                </div>
                <div class="p-3 bg-white/10 rounded-2xl backdrop-blur-sm">
                    <svg class="w-8 h-8 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </div>
            
            <div class="mt-12 grid grid-cols-3 gap-6 pt-6 border-t border-white/10 relative z-10">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-widest opacity-50 block mb-1">Server Time</span>
                    <span class="text-lg font-black font-mono text-indigo-200"><?= date('H:i') ?> WITA</span>
                </div>
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-widest opacity-50 block mb-1">PHP Version</span>
                    <span class="text-lg font-black font-mono text-indigo-200"><?= phpversion() ?></span>
                </div>
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-widest opacity-50 block mb-1">Integritas Tabel</span>
                    <span class="text-lg font-black text-emerald-400">100% Valid</span>
                </div>
            </div>
            
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl transition-transform duration-1000 group-hover:scale-125"></div>
        </div>

        <div class="md:col-span-4 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between hover:border-indigo-200 transition-colors">
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6">Distribusi Pengguna</h3>
                <div class="flex items-end gap-3 mb-8">
                    <span class="text-6xl font-black tracking-tighter text-indigo-600"><?= $total_users ?? 0 ?></span>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Akun Aktif</span>
                </div>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-xs font-bold border-b border-slate-50 pb-2">
                        <span class="text-slate-500 uppercase">Kepala Balai</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    </div>
                    <div class="flex justify-between items-center text-xs font-bold border-b border-slate-50 pb-2">
                        <span class="text-slate-500 uppercase">Kasubbag Umum</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    </div>
                    <div class="flex justify-between items-center text-xs font-bold border-b border-slate-50 pb-2">
                        <span class="text-slate-500 uppercase">Staff Gudang</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    </div>
                </div>
            </div>
            <a href="<?= base_url('users') ?>" class="mt-6 text-center block w-full py-3.5 rounded-xl bg-indigo-50 text-indigo-700 text-xs font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all">
                Manajemen Akses &rarr;
            </a>
        </div>

        <div class="md:col-span-12 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">System & Activity Logs</h3>
                <span class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg tracking-widest">10 Aktivitas Terakhir</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <?php if(!empty($logs)): foreach($logs as $log): ?>
                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 hover:border-indigo-200 transition-colors">
                    <span class="text-[9px] font-black text-indigo-500 uppercase tracking-widest block mb-2"><?= date('d M Y H:i', strtotime($log['waktu'])) ?></span>
                    <p class="text-[11px] font-bold text-slate-700 leading-relaxed"><?= $log['aktivitas'] ?></p>
                </div>
                <?php endforeach; else: ?>
                    <p class="text-xs text-slate-400 font-bold italic col-span-5 text-center py-4">Sistem belum merekam aktivitas apapun.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>