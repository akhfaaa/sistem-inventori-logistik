<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function main()
{
    $db = \Config\Database::connect();

    $semuaBarang = $db->table('tb_barang')->get()->getResultArray();
    $lowStockCount = 0;
    foreach ($semuaBarang as $b) {
        if ($b['stok_aktual'] <= $b['batas_stok_kritis']) {
            $lowStockCount++;
        }
    }

    $data = [
        'title'        => 'Dashboard Utama | Logistics Hub',
        'total_barang' => count($semuaBarang),
        'low_stock'    => $lowStockCount,
        'rekap_kmeans' => $db->table('tb_klaster_kmeans')->select('label_klaster, COUNT(*) as total')->groupBy('label_klaster')->get()->getResultArray(),
        'plot_data'    => json_encode($db->table('tb_klaster_kmeans k')->select('k.velocity_score as x, b.stok_aktual as y, k.label_klaster, b.nama_barang')->join('tb_barang b', 'b.id_barang = k.id_barang')->get()->getResultArray()),
        'recent_logs'  => $db->table('tb_log_aktivitas')->orderBy('waktu', 'DESC')->limit(5)->get()->getResultArray() // Ambil 5 log terbaru
    ];

    return view('dashboard_fix', $data);
}

    public function exportPDF()
    {
        $db = \Config\Database::connect();

        // Ambil data lengkap barang beserta label klasternya
        $data['barang'] = $db->table('tb_barang b')
            ->select('b.*, k.label_klaster, k.velocity_score')
            ->join('tb_klaster_kmeans k', 'k.id_barang = b.id_barang', 'left')
            ->get()->getResultArray();

        $data['title'] = "Laporan Strategis Inventori - " . date('d/m/Y');

        // Load view untuk template PDF
        $html = view('laporan_pdf', $data);

        // Konfigurasi DomPDF
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Download file
        return $dompdf->stream("Laporan_Inventori_" . date('Ymd') . ".pdf", ["Attachment" => true]);
    }
}
