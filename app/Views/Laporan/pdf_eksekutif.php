<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Executive Summary' ?></title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; line-height: 1.5; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #f59e0b; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #0f172a; font-size: 20px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #64748b; font-size: 11px; }
        .section-title { background-color: #0f172a; color: #fff; padding: 6px 10px; font-size: 12px; font-weight: bold; margin-top: 20px; }
        .grid-summary { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .grid-summary td { width: 50%; padding: 15px; border: 1px solid #e2e8f0; vertical-align: top; }
        .stat-value { font-size: 24px; font-weight: bold; color: #0f172a; margin-top: 5px; }
        .stat-label { font-size: 10px; text-transform: uppercase; color: #64748b; font-weight: bold; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #cbd5e1; padding: 8px; text-align: left; }
        table.data-table th { background-color: #f8fafc; color: #0f172a; font-size: 10px; text-transform: uppercase; }
        .text-right { text-align: right !important; }
        .text-danger { color: #dc2626; font-weight: bold; }
        .footer { margin-top: 50px; text-align: right; }
        .ttd-space { height: 80px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Executive Summary - SILABAK</h1>
        <p>Sistem Informasi Logistik dan Analitik Barang K-Means<br>
        Bapekom PU Wilayah VII Banjarmasin | Periode: <?= $tanggal ?? date('F Y') ?></p>
    </div>

    <div class="section-title">A. STATUS KEUANGAN & OPERASIONAL (BULAN INI)</div>
    <table class="grid-summary">
        <tr>
            <td>
                <div class="stat-label">Total Valuasi Aset Fisik</div>
                <div class="stat-value">Rp <?= number_format($valuasi['total_nilai'] ?? 0, 0, ',', '.') ?></div>
                <div style="font-size:10px; margin-top:5px; color:#64748b;">Tersebar dalam <?= $valuasi['total_sku'] ?? 0 ?> Master SKU</div>
            </td>
            <td>
                <div class="stat-label">Volume Mutasi Bulanan</div>
                <div class="stat-value" style="font-size: 18px;">
                    Masuk: +<?= $inbound ?? 0 ?> Unit<br>
                    Keluar: -<?= $outbound ?? 0 ?> Unit
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">B. ANALISIS SPASIAL K-MEANS (KESEHATAN INVENTORI)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Klaster Algoritma AI</th>
                <th class="text-right">Total SKU</th>
                <th>Keterangan / Rekomendasi Sistem</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($kmeans ?? [])): ?>
                <tr><td colspan="3" style="text-align:center;">Data K-Means belum diproses.</td></tr>
            <?php else: foreach($kmeans ?? [] as $k): ?>
                <tr>
                    <td style="font-weight: bold;"><?= $k['label_klaster'] ?></td>
                    <td class="text-right font-bold"><?= $k['total'] ?></td>
                    <td style="font-size: 10px;">
                        <?php 
                            if($k['label_klaster'] == 'Fast Moving') echo "Rotasi cepat. Jaga level stok (Prioritas Restock).";
                            elseif($k['label_klaster'] == 'Slow Moving') echo "Rotasi lambat. Pantau pergerakan distribusi.";
                            elseif($k['label_klaster'] == 'Dead Stock') echo "Aset macet. Pertimbangkan likuidasi atau pemusnahan.";
                        ?>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>

    <div class="section-title">C. DAFTAR PERHATIAN KHUSUS (STOK KRITIS)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Master Aset</th>
                <th class="text-right">Stok Aktual</th>
                <th class="text-right">Batas Minimum</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($kritis ?? [])): ?>
                <tr><td colspan="4" style="text-align:center;">Tidak ada stok kritis. Kondisi aman.</td></tr>
            <?php else: foreach($kritis ?? [] as $krt): ?>
                <tr>
                    <td><?= $krt['kode_barang'] ?></td>
                    <td><?= $krt['nama_barang'] ?></td>
                    <td class="text-right text-danger"><?= $krt['stok_aktual'] ?> Unit</td>
                    <td class="text-right"><?= $krt['stok_minimum'] ?> Unit</td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Banjarmasin, <?= $tanggal ?? date('d F Y') ?></p>
        <p><b>Kepala Balai Pengembangan Kompetensi PU Wil. VII Banjarmasin</b></p>
        <div class="ttd-space"></div>
        <p>____________________________________</p>
        <p style="font-size:10px; color:#64748b;">Dokumen dihasilkan secara otomatis oleh Sistem SILABAK.</p>
    </div>

</body>
</html>