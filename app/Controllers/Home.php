<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function main()
    {
        $db = \Config\Database::connect();

        // Mengambil semua data barang dari tabel tb_barang
        $semuaBarang = $db->table('tb_barang')->get()->getResultArray();
        
        // Inisialisasi penghitung untuk barang dengan stok rendah
        $lowStockCount = 0;
        
        // Melakukan iterasi untuk memeriksa stok setiap barang terhadap batas kritisnya
        // Menggunakan logika PHP ini lebih aman untuk menghindari bentrokan query SQL jika terdapat inkonsistensi kolom
        foreach ($semuaBarang as $b) {
            if ($b['stok_aktual'] <= $b['batas_stok_kritis']) {
                $lowStockCount++;
            }
        }

        $data = [
            'title'        => 'Dashboard Utama | Logistics Hub',
            'total_barang' => count($semuaBarang),
            'low_stock'    => $lowStockCount,
            // Mengambil rekapitulasi jumlah barang per label klaster K-Means
            'rekap_kmeans' => $db->table('tb_klaster_kmeans')
                                ->select('label_klaster, COUNT(*) as total')
                                ->groupBy('label_klaster')
                                ->get()->getResultArray(),
            // Menyiapkan data koordinat untuk visualisasi Scatter Plot di Dashboard
            'plot_data'    => json_encode($db->table('tb_klaster_kmeans k')
                                ->select('k.velocity_score as x, b.stok_aktual as y, k.label_klaster, b.nama_barang')
                                ->join('tb_barang b', 'b.id_barang = k.id_barang')
                                ->get()->getResultArray()),
            // Mengambil 5 riwayat aktivitas terbaru dari Audit Log
            'recent_logs'  => $db->table('tb_log_aktivitas')
                                ->orderBy('waktu', 'DESC')
                                ->limit(5)
                                ->get()->getResultArray() 
        ];

        return view('dashboard_fix', $data);
    }

    public function exportPDF()
    {
        $db = \Config\Database::connect();

        // Mengambil data lengkap barang beserta label klasternya untuk keperluan laporan PDF
        $data['barang'] = $db->table('tb_barang b')
            ->select('b.*, k.label_klaster, k.velocity_score')
            ->join('tb_klaster_kmeans k', 'k.id_barang = b.id_barang', 'left')
            ->get()->getResultArray();

        $data['title'] = "Laporan Strategis Inventori - " . date('d/m/Y');

        // Memuat template view laporan
        $html = view('laporan_pdf', $data);

        // Inisialisasi library DomPDF untuk konversi HTML ke PDF
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Mengirimkan hasil render PDF ke browser dengan nama file yang menyertakan tanggal
        return $dompdf->stream("Laporan_Inventori_" . date('Ymd') . ".pdf", ["Attachment" => true]);
    }
}