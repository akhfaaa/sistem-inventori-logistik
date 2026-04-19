<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; }
        
        /* Kop Surat Resmi */
        .kop-surat { width: 100%; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center; }
        .kop-surat h1 { font-size: 18px; margin: 0; padding: 0; text-transform: uppercase; }
        .kop-surat p { font-size: 11px; margin: 5px 0 0 0; color: #555; }
        
        /* Judul Laporan */
        .judul-laporan { text-align: center; font-size: 14px; font-weight: bold; margin-bottom: 20px; text-decoration: underline; text-transform: uppercase; }
        
        /* Tabel Data */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #f4f4f5; font-weight: bold; text-align: center; text-transform: uppercase; font-size: 10px; }
        
        /* Alignment Spesifik */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        /* Footer TTD */
        .ttd-box { width: 100%; margin-top: 40px; }
        .ttd-box table { width: 100%; border: none; }
        .ttd-box td { border: none; text-align: center; width: 33%; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h1>BAPEKOM PUPR WILAYAH VII BANJARMASIN</h1>
        <p>Jl. Contoh Alamat Resmi No. 123, Banjarmasin, Kalimantan Selatan</p>
        <p>Sistem Informasi Manajemen Logistik (Logistics Hub Enterprise)</p>
    </div>

    <div class="judul-laporan"><?= $title ?></div>
    
    <p>Dicetak pada: <?= date('d F Y H:i:s') ?><br>Oleh: <?= session()->get('nama_lengkap') ?> (<?= session()->get('role') ?>)</p>

    <table>
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="15%">SKU</th>
                <th width="30%">NAMA BARANG</th>
                <th width="20%">KATEGORI</th>
                <th width="15%">LOKASI RAK</th>
                <th width="15%">STOK AKTUAL</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($barang as $b): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="text-center"><b><?= $b['kode_barang'] ?></b></td>
                <td><?= $b['nama_barang'] ?></td>
                <td class="text-center"><?= $b['nama_kategori'] ?? '-' ?></td>
                <td class="text-center"><?= $b['nama_rak'] ?? '-' ?></td>
                <td class="text-center"><b><?= $b['stok_aktual'] ?></b> Unit</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="ttd-box">
        <table>
            <tr>
                <td></td>
                <td></td>
                <td>
                    Banjarmasin, <?= date('d F Y') ?><br>
                    Mengetahui,<br>
                    <b>Kepala Gudang / Administrator</b>
                    <br><br><br><br><br>
                    <u><?= session()->get('nama_lengkap') ?></u><br>
                    NIP. ........................................
                </td>
            </tr>
        </table>
    </div>

</body>
</html>