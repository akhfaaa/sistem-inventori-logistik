<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { bg-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 30px; }
        .label { padding: 3px 8px; border-radius: 3px; color: white; font-weight: bold; }
        .fast { background-color: #28a745; }
        .slow { background-color: #ffc107; color: black; }
        .dead { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LOGISTICS HUB - LAPORAN INVENTORI</h2>
        <p>Tanggal Cetak: <?= date('d F Y H:i') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Status K-Means</th>
                <th>Velocity</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($barang as $index => $b): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $b['kode_barang'] ?></td>
                <td><?= $b['nama_barang'] ?></td>
                <td><?= $b['stok_aktual'] ?></td>
                <td><?= $b['label_klaster'] ?? 'Belum Dianalisis' ?></td>
                <td><?= $b['velocity_score'] ?? 0 ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>