<?php

namespace App\Controllers;

class Laporan extends BaseController
{
    /**
     * Tampilkan halaman pusat laporan.
     * Hanya dapat diakses oleh role manajerial.
     */
    public function index()
    {
        $role = session()->get('role');

        if (! in_array($role, ['Administrator', 'Kepala Balai', 'Kasubbag'])) {
            return redirect()->to('/home')->with('error', 'Otoritas ditolak. Anda tidak memiliki akses ke Pusat Laporan.');
        }

        $db = \Config\Database::connect();
        $data = [
            'title' => 'Pusat Laporan | SILABAK',

            // Data klaster K-Means untuk chart ringkas di dashboard laporan
            'kmeans_chart' => $db->table('tb_klaster_kmeans')
                ->select('label_klaster, COUNT(*) as total')
                ->groupBy('label_klaster')
                ->get()
                ->getResultArray(),
        ];

        return view('Laporan/index', $data);
    }

    // --- 1. LAPORAN EKSEKUTIF (GABUNGAN) ---
    /**
     * Cetak laporan eksekutif ke PDF.
     * Menyajikan ringkasan aset, klaster AI, stok kritis, inbound, dan outbound.
     */
    public function eksekutif()
    {
        if (! in_array(session()->get('role'), ['Administrator', 'Kepala Balai', 'Kasubbag'])) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $db = \Config\Database::connect();
        $bulan_ini = date('Y-m');

        $valuasi = $db->table('tb_barang')
            ->select('COUNT(id_barang) as total_sku, SUM(harga_beli * stok_aktual) as total_nilai')
            ->get()
            ->getRowArray();

        $data = [
            'title'    => 'Laporan Eksekutif SILABAK',
            'tanggal'  => date('d F Y'),
            'valuasi'  => $valuasi,
            'kmeans'   => $db->table('tb_klaster_kmeans')
                ->select('label_klaster, COUNT(*) as total')
                ->groupBy('label_klaster')
                ->get()
                ->getResultArray(),
            'kritis'   => $db->table('tb_barang')
                ->where('stok_aktual <= stok_minimum')
                ->limit(10)
                ->get()
                ->getResultArray(),
            'inbound'  => $db->table('tb_masuk')
                ->where("DATE_FORMAT(tanggal_masuk, '%Y-%m')", $bulan_ini)
                ->selectSum('qty_masuk')
                ->get()
                ->getRow()?->qty_masuk ?? 0,
            'outbound' => $db->table('tb_keluar')
                ->where("DATE_FORMAT(tanggal_keluar, '%Y-%m')", $bulan_ini)
                ->selectSum('qty_keluar')
                ->get()
                ->getRow()?->qty_keluar ?? 0,
        ];

        $html = view('Laporan/pdf_eksekutif', $data);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->setOptions(new \Dompdf\Options([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled'      => true,
        ]));
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream('Executive_Summary_' . date('Ymd') . '.pdf', ['Attachment' => false]);
    }

    // --- 2. FUNGSI CETAK UNIVERSAL (UNTUK 11 LAPORAN LAINNYA) ---
    /**
     * Generate PDF untuk berbagai jenis laporan berdasarkan parameter type.
     * Menyiapkan data tabel sesuai jenis laporan.
     *
     * @param string $type
     */
    public function generate($type)
    {
        $db = \Config\Database::connect();

        $data = [
            'title'     => '',
            'columns'   => [],
            'data_list' => [],
        ];

        switch ($type) {
            // --- KATEGORI OPERASIONAL ---
            case 'master_inventori':
                $data['title'] = 'Laporan Master Inventori Global';
                $data['columns'] = ['Kode Aset', 'Nama Barang', 'Stok Aktual', 'Batas Min', 'Harga Satuan'];
                $query = $db->table('tb_barang')
                    ->get()
                    ->getResultArray();
                foreach ($query as $row) {
                    $data['data_list'][] = [
                        $row['kode_barang'],
                        $row['nama_barang'],
                        $row['stok_aktual'] . ' Unit',
                        $row['stok_minimum'] . ' Unit',
                        'Rp ' . number_format($row['harga_beli'], 0, ',', '.'),
                    ];
                }
                break;

            case 'barang_masuk':
                $data['title'] = 'Log Penerimaan Logistik (Inbound)';
                $data['columns'] = ['Waktu Masuk', 'Nama Barang', 'Kuantitas', 'Aktor Verifikasi'];
                $query = $db->table('tb_masuk m')
                    ->join('tb_barang b', 'b.id_barang = m.id_barang', 'left')
                    ->join('tb_users u', 'u.id_user = m.id_user', 'left')
                    ->orderBy('m.tanggal_masuk', 'DESC')
                    ->get()
                    ->getResultArray();
                foreach ($query as $row) {
                    $data['data_list'][] = [
                        date('d/m/Y H:i', strtotime($row['tanggal_masuk'])),
                        $row['nama_barang'],
                        $row['qty_masuk'] . ' Unit',
                        $row['nama_lengkap'] ?? 'Sistem',
                    ];
                }
                break;

            case 'barang_keluar':
                $data['title'] = 'Log Distribusi Logistik (Outbound)';
                $data['columns'] = ['Waktu Keluar', 'Nama Barang', 'Kuantitas', 'Aktor Verifikasi'];
                $query = $db->table('tb_keluar k')
                    ->join('tb_barang b', 'b.id_barang = k.id_barang', 'left')
                    ->join('tb_users u', 'u.id_user = k.id_user', 'left')
                    ->orderBy('k.tanggal_keluar', 'DESC')
                    ->get()
                    ->getResultArray();
                foreach ($query as $row) {
                    $data['data_list'][] = [
                        date('d/m/Y H:i', strtotime($row['tanggal_keluar'])),
                        $row['nama_barang'],
                        $row['qty_keluar'] . ' Unit',
                        $row['nama_lengkap'] ?? 'Sistem',
                    ];
                }
                break;

            // --- KATEGORI KECERDASAN BUATAN ---
            case 'fast_moving':
            case 'slow_moving':
            case 'dead_stock':
                $label = ucwords(str_replace('_', ' ', $type));
                $data['title'] = 'Laporan Klaster AI - ' . $label;
                $data['columns'] = ['Kode', 'Nama Barang', 'Stok Aktual', 'Velocity Score'];
                $query = $db->table('tb_klaster_kmeans k')
                    ->join('tb_barang b', 'b.id_barang = k.id_barang')
                    ->where('k.label_klaster', $label)
                    ->get()
                    ->getResultArray();
                foreach ($query as $row) {
                    $data['data_list'][] = [
                        $row['kode_barang'],
                        $row['nama_barang'],
                        $row['stok_aktual'] . ' Unit',
                        $row['velocity_score'],
                    ];
                }
                break;

            case 'stok_kritis':
                $data['title'] = 'Daftar Ambang Stok Kritis';
                $data['columns'] = ['Kode', 'Nama Barang', 'Sisa Stok', 'Batas Minimum', 'Kekurangan'];
                $query = $db->table('tb_barang')
                    ->where('stok_aktual <= stok_minimum')
                    ->get()
                    ->getResultArray();
                foreach ($query as $row) {
                    $kurang = $row['stok_minimum'] - $row['stok_aktual'];
                    $data['data_list'][] = [
                        $row['kode_barang'],
                        $row['nama_barang'],
                        $row['stok_aktual'] . ' Unit',
                        $row['stok_minimum'] . ' Unit',
                        '- ' . $kurang . ' Unit',
                    ];
                }
                break;

            case 'valuasi_aset':
                $data['title'] = 'Kalkulasi Valuasi Aset Fisik';
                $data['columns'] = ['Nama Barang', 'Kuantitas', 'Harga Beli Satuan', 'Total Valuasi'];
                $total_semua = 0;
                $query = $db->table('tb_barang')
                    ->get()
                    ->getResultArray();
                foreach ($query as $row) {
                    $subtotal = $row['stok_aktual'] * $row['harga_beli'];
                    $total_semua += $subtotal;
                    $data['data_list'][] = [
                        $row['nama_barang'],
                        $row['stok_aktual'] . ' Unit',
                        'Rp ' . number_format($row['harga_beli'], 0, ',', '.'),
                        'Rp ' . number_format($subtotal, 0, ',', '.'),
                    ];
                }
                $data['total_summary'] = $total_semua; // Total valuasi untuk ringkasan di PDF
                break;

            case 'system_log':
                $data['title'] = 'Security & System Audit Log';
                $data['columns'] = ['Waktu', 'Modul', 'Aktivitas Terekam', 'Aktor (Otoritas)'];
                $query = $db->table('tb_log_aktivitas l')
                    ->join('tb_users u', 'u.id_user = l.id_user', 'left')
                    ->orderBy('l.waktu', 'DESC')
                    ->limit(100)
                    ->get()
                    ->getResultArray();
                foreach ($query as $row) {
                    $data['data_list'][] = [
                        date('d/m/y H:i:s', strtotime($row['waktu'])),
                        $row['modul'],
                        $row['aksi'],
                        $row['nama_lengkap'] ?? 'System/Deleted',
                    ];
                }
                break;

            default:
                return redirect()->back()->with('error', 'Jenis laporan tidak dikenali sistem.');
        }

        // Render ke PDF menggunakan view cetak_pdf.php (Template Universal)
        $html = view('Laporan/cetak_pdf', $data);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->setOptions(new \Dompdf\Options([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled'      => true,
        ]));
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Gunakan false agar PDF langsung terbuka di Tab baru browser (Preview)
        return $dompdf->stream("Laporan_{$type}_" . date('Ymd') . '.pdf', ['Attachment' => false]);
    }
}