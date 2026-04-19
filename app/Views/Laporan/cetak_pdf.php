<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $judul_laporan ?></title>
    <style>
        /* Standar CSS Enterprise untuk Cetak PDF */
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #334155; }
        .header { border-bottom: 2px solid #4f46e5; padding-bottom: 15px; margin-bottom: 25px; }
        .logo-text { font-size: 24px; font-weight: bold; color: #0f172a; margin: 0; }
        .logo-text span { color: #4f46e5; }
        .doc-title { font-size: 16px; font-weight: bold; color: #334155; margin-top: 5px; margin-bottom: 0; text-transform: uppercase; }
        .meta-data { font-size: 10px; color: #64748b; margin-top: 5px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #e2e8f0; padding: 10px 12px; text-align: left; }
        th { background-color: #f8fafc; color: #475569; font-size: 11px; text-transform: uppercase; font-weight: bold; }
        tr:nth-child(even) { background-color: #f8fafc; }
        
        /* Format angka (Rupiah/Qty) rata kanan */
        .text-right { text-align: right; }
        .footer { position: fixed; bottom: -20px; left: 0; right: 0; text-align: center; font-size: 10px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="logo-text">Logistics<span>Hub</span> Enterprise</h1>
        <h2 class="doc-title"><?= $judul_laporan ?></h2>
        <div class="meta-data">
            Dicetak oleh: <?= session()->get('nama_lengkap') ?? 'Sistem' ?> | Tanggal: <?= $tanggal_cetak ?>
        </div>
    </div>

    <?php if(empty($laporan)): ?>
        <p style="text-align: center; margin-top: 50px; color: #94a3b8; font-style: italic;">
            Data tidak ditemukan untuk laporan ini pada periode yang dipilih.
        </p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <?php 
                        // MENGAMBIL HEADER SECARA DINAMIS DARI QUERY SQL
                        $headers = array_keys($laporan[0]);
                        foreach($headers as $head): 
                            // Membersihkan nama kolom (ubah _ jadi spasi)
                            $cleanHeader = ucwords(str_replace('_', ' ', $head));
                    ?>
                        <th><?= $cleanHeader ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($laporan as $row): ?>
                <tr>
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <?php foreach($row as $key => $value): 
                        // Deteksi otomatis jika itu angka (Rupiah/Stok) untuk dirata-kanankan
                        $isNumeric = is_numeric($value);
                        $class = $isNumeric ? 'class="text-right"' : '';
                        
                        // Format Uang khusus jika kolom mengandung kata 'valuasi' atau 'harga'
                        if($isNumeric && (strpos($key, 'valuasi') !== false || strpos($key, 'harga') !== false)){
                            $value = 'Rp ' . number_format($value, 0, ',', '.');
                        }
                    ?>
                        <td <?= $class ?>><?= $value ?></td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="footer">
        Dokumen ini digenerasi secara otomatis oleh Sistem Logistics Hub. Dokumen ini sah tanpa tanda tangan.
    </div>

</body>
</html>