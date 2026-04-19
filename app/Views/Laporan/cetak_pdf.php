<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $judul_laporan ?></title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #1e293b; }
        
        /* Kop Surat Bapekom PUPR */
        .kop-surat { width: 100%; border-bottom: 3px solid #0f172a; padding-bottom: 10px; margin-bottom: 25px; text-align: center; }
        .kop-surat h1 { font-size: 16px; margin: 0 0 5px 0; text-transform: uppercase; letter-spacing: 1px; color: #0f172a; }
        .kop-surat p { font-size: 10px; margin: 0; color: #475569; }
        
        /* Header Laporan */
        .judul-dokumen { text-align: center; font-size: 14px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; text-decoration: underline; }
        .info-meta { text-align: center; font-size: 10px; color: #64748b; margin-bottom: 25px; }

        /* Tabel Otomatis */
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px 10px; }
        th { background-color: #f8fafc; text-align: left; font-weight: bold; color: #334155; text-transform: uppercase; font-size: 9px; }
        
        /* Pewarnaan Khusus Angka */
        td.angka { text-align: right; font-weight: bold; }
        
        /* Kolom Tanda Tangan */
        .ttd-box { width: 100%; margin-top: 30px; page-break-inside: avoid; }
        .ttd-box table { border: none; }
        .ttd-box td { border: none; text-align: center; width: 33%; vertical-align: top; }
        .ttd-nama { font-weight: bold; text-decoration: underline; margin-top: 60px; display: block; }
    </style>
</head>
<body>

    <table class="kop-surat" style="border-bottom: 4px double #000; margin-bottom: 25px; width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 15%; text-align: center; vertical-align: middle; border: none; padding-bottom: 10px;">
                <?php
                    // Trik Dompdf: Menggunakan path absolut lokal & mengubahnya ke Base64 agar pasti ter-render
                    $logoPath = FCPATH . 'assets/img/logo_pupr.png';
                    if(file_exists($logoPath)) {
                        $logoData = base64_encode(file_get_contents($logoPath));
                        $logoSrc = 'data:image/png;base64,' . $logoData;
                    } else {
                        // Jika file lokal belum ada, pakai fallback dari internet
                        $logoSrc = 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0e/Logo_PUPR.png/320px-Logo_PUPR.png';
                    }
                ?>
                <img src="<?= $logoSrc ?>" alt="Logo PUPR" style="width: 80px; height: auto;">
            </td>
            
            <td style="width: 70%; text-align: center; vertical-align: middle; border: none; padding-bottom: 10px;">
                <h2 style="font-size: 16px; margin: 0; color: #000; font-weight: normal; letter-spacing: 1px;">KEMENTERIAN PEKERJAAN UMUM</h2>
                <h1 style="font-size: 18px; margin: 5px 0; text-transform: uppercase; letter-spacing: 1px; color: #000; font-weight: 900;">
                    BALAI PENGEMBANGAN KOMPETENSI PU WILAYAH VII BANJARMASIN
                </h1>
                <p style="font-size: 11px; margin: 0; color: #333;">
                    Jl. Beruntung Jaya No.9, Pemurus Dalam, Kec. Banjarmasin Sel., Kota Banjarmasin, Kalimantan Selatan<br>
                    <strong>Sistem Informasi Logistik dan Analitik Barang K-Means (SILABAK)</strong>
                </p>
            </td>
            
            <td style="width: 15%; border: none;"></td>
        </tr>
    </table>

    <div class="judul-dokumen"><?= $judul_laporan ?></div>
    <div class="info-meta">Dicetak pada: <?= $tanggal_cetak ?> WITA</div>

    <?php if(!empty($laporan)): ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%; text-align:center;">NO</th>
                    <?php foreach(array_keys($laporan[0]) as $header): ?>
                        <th><?= $header ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($laporan as $baris): ?>
                    <tr>
                        <td style="text-align:center;"><?= $no++ ?></td>
                        <?php foreach($baris as $nilai): ?>
                            <?php 
                                // Deteksi jika nilainya berupa angka besar (seperti Harga), otomatis format Rupiah
                                $isAngkaBesar = is_numeric($nilai) && $nilai > 1000;
                            ?>
                            <td class="<?= is_numeric($nilai) ? 'angka' : '' ?>">
                                <?= $isAngkaBesar ? 'Rp ' . number_format($nilai, 0, ',', '.') : $nilai ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; color: #ef4444; padding: 20px; border: 1px dashed #fca5a5;">
            Belum ada data transaksi atau rekaman untuk kategori laporan ini.
        </p>
    <?php endif; ?>

    <div class="ttd-box">
        <table>
            <tr>
                <td></td>
                <td></td>
                <td>
                    Banjarmasin, <?= date('d F Y') ?><br>
                    Mengetahui,<br>
                    <b>Kepala Sub Bagian Umum dan Tata Usaha</b>
                    <span class="ttd-nama"><?= strtoupper($pencetak) ?></span>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>