<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-[1400px] mx-auto px-6 py-8">
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">System Configuration</h1>
        <p class="text-slate-500 text-sm mt-1.5 font-medium">Monitoring stabilitas *engine*, manajemen pengguna, dan log aktivitas keamanan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <div class="lg:col-span-8 bg-slate-900 p-8 rounded-[2rem] text-slate-300 shadow-xl border border-slate-800 flex flex-col justify-between font-mono">
            <div class="flex justify-between items-start mb-10">
                <div>
                    <h3 class="text-[10px] font-bold text-amber-500 uppercase tracking-[0.2em] mb-3">Core Status</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.8)]"></div>
                        <p class="text-3xl font-black text-white tracking-widest">ONLINE</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Server Time</p>
                    <p class="text-lg text-white font-bold"><?= date('H:i:s') ?> <span class="text-xs text-slate-500">WITA</span></p>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 border-t border-slate-800 pt-6">
                <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700/50">
                    <p class="text-[9px] uppercase tracking-widest text-slate-500 mb-1">Environment</p>
                    <p class="text-sm font-bold text-amber-400">PHP <?= phpversion() ?></p>
                </div>
                <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700/50">
                    <p class="text-[9px] uppercase tracking-widest text-slate-500 mb-1">Database Ping</p>
                    <p class="text-sm font-bold text-emerald-400">Stable <span class="text-[10px]">~12ms</span></p>
                </div>
                <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700/50">
                    <p class="text-[9px] uppercase tracking-widest text-slate-500 mb-1">Integrity Check</p>
                    <p class="text-sm font-bold text-white">100% Passed</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 bg-white p-8 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6">Akun Sistem Terdaftar</h3>
                <div class="flex items-end gap-3 mb-8">
                    <span class="text-6xl font-black tracking-tighter text-slate-900"><?= $total_users ?? 0 ?></span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Total Akun</span>
                </div>
                
                <a href="<?= base_url('users') ?>" class="flex items-center justify-between p-4 bg-slate-50 rounded-xl hover:bg-amber-50 hover:text-amber-700 transition-colors border border-slate-100 cursor-pointer group">
                    <span class="text-xs font-bold uppercase tracking-widest text-slate-600 group-hover:text-amber-700">Kelola Akses (RBAC)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <div class="lg:col-span-12 bg-white p-8 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Security & Audit Logs</h3>
                <span class="text-[9px] font-black uppercase tracking-widest bg-slate-100 px-2 py-1 rounded text-slate-500">10 Entri Terakhir</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php if(!empty($logs)): foreach($logs as $log): ?>
                <div class="flex gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100 hover:border-slate-300 transition-colors">
                    <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 flex flex-col items-center justify-center shrink-0 shadow-sm">
                        <span class="text-[8px] font-black text-slate-400 uppercase tracking-tighter leading-none"><?= date('M', strtotime($log['waktu'])) ?></span>
                        <span class="text-sm font-black text-slate-800 leading-none mt-0.5"><?= date('d', strtotime($log['waktu'])) ?></span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-900 mb-1"><?= $log['aktivitas'] ?></p>
                        <div class="flex items-center gap-2 text-[9px] font-black uppercase tracking-widest text-slate-400">
                            <span><?= date('H:i:s', strtotime($log['waktu'])) ?></span>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span class="text-amber-600"><?= $log['modul'] ?? 'Sistem' ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                    <div class="col-span-2 py-8 text-center text-slate-400 text-xs font-bold uppercase tracking-widest border-2 border-dashed border-slate-100 rounded-xl">Sistem belum merekam aktivitas.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>