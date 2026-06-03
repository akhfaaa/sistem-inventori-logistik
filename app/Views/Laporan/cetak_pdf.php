<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Laporan' ?></title>
    <style>
        @page { margin: 1.5cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.4; font-size: 11px; margin: 0; }

        /* KOP SURAT MODERN (Tanpa Gambar, Fokus Tipografi) */
        .kop-surat { text-align: center; border-bottom: 2px solid #f59e0b; padding-bottom: 15px; margin-bottom: 25px; }
        .kop-surat h1 { margin: 0; font-size: 18px; text-transform: uppercase; color: #0f172a; font-weight: 900; letter-spacing: 0.5px; }
        .kop-surat h2 { margin: 4px 0; font-size: 13px; text-transform: uppercase; color: #334155; }
        .kop-surat p { margin: 5px 0 0; font-size: 10px; color: #64748b; }

        /* JUDUL LAPORAN */
        .report-title { text-align: center; margin-bottom: 20px; }
        .report-title h3 { margin: 0; font-size: 16px; text-decoration: underline; color: #000; text-transform: uppercase; }
        .report-title p { margin: 6px 0; font-size: 10px; font-weight: bold; color: #475569; letter-spacing: 1px; }

        /* TABEL DATA */
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data-table th { background-color: #f8fafc; border: 1px solid #cbd5e1; padding: 10px 8px; text-align: left; font-size: 10px; text-transform: uppercase; color: #0f172a; }
        table.data-table td { border: 1px solid #cbd5e1; padding: 8px; vertical-align: top; }
        
        table.data-table tr:nth-child(even) { background-color: #fcfcfc; }

        /* UTILITAS */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        /* TANDA TANGAN */
        .footer-sign { margin-top: 40px; width: 100%; border: none; }
        .footer-sign td { border: none; padding: 0; }
        .sign-box { width: 250px; text-align: center; }
        .spacer { height: 70px; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h1>Kementerian Pekerjaan Umum</h1>
        <h2>Bapekom PU Wilayah VII Banjarmasin</h2>
        <p>Jl. Tatah Belayung Baru, Kertak Hanyar, Kab. Banjar, Kalimantan Selatan</p>
    </div>

    <div class="report-title">
        <h3><?= $title ?? 'Laporan' ?></h3>
        <p>ID DOKUMEN: SILABAK-<?= date('Ymd') ?>-<?= strtoupper(substr(md5(time()), 0, 5)) ?></p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="30" class="text-center">No</th>
                <?php if(isset($columns)): foreach($columns as $col): ?>
                    <th><?= $col ?></th>
                <?php endforeach; endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($data_list)): ?>
                <tr>
                    <td colspan="<?= isset($columns) ? count($columns) + 1 : 5 ?>" class="text-center">Data tidak ditemukan untuk periode ini.</td>
                </tr>
            <?php else: $no = 1; foreach($data_list as $row): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <?php foreach($row as $value): ?>
                        <td><?= $value ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>

    <?php if(isset($total_summary)): ?>
    <div class="text-right" style="margin-top: -10px; margin-bottom: 20px;">
        <div style="display: inline-block; border: 2px solid #0f172a; padding: 10px; background: #f8fafc;">
            <span style="font-size: 10px; font-weight: bold; color: #64748b; text-transform: uppercase;">Total Akumulasi:</span><br>
            <span style="font-size: 16px; font-weight: 900; color: #0f172a;">Rp <?= number_format($total_summary, 0, ',', '.') ?></span>
        </div>
    </div>
    <?php endif; ?>

    <table class="footer-sign">
        <tr>
            <td></td>
            <td class="sign-box">
                <p>Banjarmasin, <?= date('d F Y') ?></p>
                <p class="font-bold">Mengetahui/Menyetujui,</p>
                <p style="margin-top: -10px;">Kasubbag Umum dan Tata Usaha</p>
                <div class="spacer"></div>
                <p class="font-bold"><u>__________________________</u></p>
                <p>NIP. ........................................</p>
            </td>
        </tr>
    </table>

    <div style="position: fixed; bottom: -30px; left: 0; right: 0; font-size: 9px; color: #94a3b8; text-align: center;">
        Dicetak secara otomatis melalui Sistem Informasi Logistik dan Analitik Barang (SILABAK) - <?= date('d/m/Y H:i') ?> WITA
    </div>

</body>
</html>