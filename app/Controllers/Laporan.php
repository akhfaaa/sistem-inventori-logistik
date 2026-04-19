<?php

namespace App\Controllers;

class Laporan extends BaseController
{
   public function index()
    {
        $db = \Config\Database::connect();
        
        // Ambil rekap jumlah barang per klaster K-Means untuk visualisasi Chart.js
        $data['kmeans_chart'] = $db->table('tb_klaster_kmeans')
                                   ->select('label_klaster, COUNT(*) as total')
                                   ->groupBy('label_klaster')
                                   ->get()->getResultArray();

        $data['title'] = "Report Center | Executive Analytics";
        return view('laporan/index', $data);
    }

    public function generate($tipe)
    {
        $db = \Config\Database::connect();
        
        // Mapping Judul Laporan agar lebih rapi di PDF
        $mapJudul = [
            'inventori_master'    => 'Laporan Master Inventory Recap',
            'stok_kritis'         => 'Laporan Critical Stock Alerts',
            'inbound_rekap'       => 'Laporan Rekapitulasi Inbound Volume',
            'outbound_rekap'      => 'Laporan Rekapitulasi Outbound Volume',
            'valuasi_aset'        => 'Laporan Valuasi Aset Gudang (Warehouse Valuation)',
            'kinerja_supplier'    => 'Laporan Metrik Kinerja Supplier',
            'distribusi_customer' => 'Laporan Distribusi & Serapan Customer',
            'analitik_kmeans'     => 'Laporan Analitik Klasterisasi K-Means'
        ];

        $data['judul_laporan'] = $mapJudul[$tipe] ?? 'Laporan Manajerial Logistik';
        $data['tanggal_cetak'] = date('d F Y - H:i:s');

        // ... [Masukkan blok SWITCH CASE yang ada di jawaban sebelumnya di sini] ...
        
        switch ($tipe) {
            case 'inventori_master':
                $data['laporan'] = $db->table('tb_barang b')->select('b.kode_barang, b.nama_barang, k.nama_kategori, b.stok_aktual')->join('tb_kategori k', 'k.id_kategori = b.id_kategori')->get()->getResultArray();
                break;
            case 'stok_kritis':
                $data['laporan'] = $db->table('tb_barang')->select('kode_barang, nama_barang, stok_aktual, batas_stok_kritis')->where('stok_aktual <= batas_stok_kritis')->get()->getResultArray();
                break;
            case 'inbound_rekap':
                $data['laporan'] = $db->table('tb_masuk m')->select('b.nama_barang, s.nama_supplier, SUM(m.qty_masuk) as total_masuk')->join('tb_barang b', 'b.id_barang = m.id_barang')->join('tb_supplier s', 's.id_supplier = m.id_supplier')->groupBy('m.id_barang, m.id_supplier')->get()->getResultArray();
                break;
            case 'outbound_rekap':
                $data['laporan'] = $db->table('tb_keluar k')->select('b.nama_barang, c.nama_customer, SUM(k.qty_keluar) as total_keluar')->join('tb_barang b', 'b.id_barang = k.id_barang')->join('tb_customer c', 'c.id_customer = k.id_customer')->groupBy('k.id_barang, k.id_customer')->get()->getResultArray();
                break;
            case 'valuasi_aset':
                $data['laporan'] = $db->table('tb_barang')->select('nama_barang, stok_aktual, harga_beli, (stok_aktual * harga_beli) as total_valuasi')->get()->getResultArray();
                break;
            case 'kinerja_supplier':
                $data['laporan'] = $db->table('tb_masuk m')->select('s.nama_supplier, COUNT(m.id_masuk) as frekuensi_pengiriman, SUM(m.qty_masuk) as volume_barang')->join('tb_supplier s', 's.id_supplier = m.id_supplier')->groupBy('m.id_supplier')->orderBy('volume_barang', 'DESC')->get()->getResultArray();
                break;
            case 'distribusi_customer':
                $data['laporan'] = $db->table('tb_keluar k')->select('c.nama_customer, SUM(k.qty_keluar) as volume_serapan')->join('tb_customer c', 'c.id_customer = k.id_customer')->groupBy('k.id_customer')->orderBy('volume_serapan', 'DESC')->get()->getResultArray();
                break;
            case 'analitik_kmeans':
                $data['laporan'] = $db->table('tb_klaster_kmeans k')->select('b.nama_barang, k.label_klaster, k.velocity_score')->join('tb_barang b', 'b.id_barang = k.id_barang')->orderBy('k.label_klaster', 'ASC')->get()->getResultArray();
                break;
            default:
                $data['laporan'] = [];
        }

        // ==========================================
        // PROSES RENDER DOMPDF
        // ==========================================
        $html = view('laporan/cetak_pdf', $data);

        $dompdf = new \Dompdf\Dompdf();
        // Set opsi agar DomPDF bisa me-render CSS dengan lebih baik
        $options = $dompdf->getOptions();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);

        $dompdf->loadHtml($html);
        
        // Kita gunakan Landscape karena tabel laporan biasanya lebar
        $dompdf->setPaper('A4', 'landscape'); 
        $dompdf->render();

        $namaFile = "Report_" . strtoupper($tipe) . "_" . date('Ymd_Hi') . ".pdf";
        
        // Unduh otomatis
        return $dompdf->stream($namaFile, ["Attachment" => true]);
    }
}