<?php

namespace App\Controllers;

class Laporan extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
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
        
        $mapJudul = [
            'master_inventori' => '1. Laporan Master Inventori Global',
            'barang_masuk'     => '2. Laporan Transaksi Barang Masuk',
            'barang_keluar'    => '3. Laporan Distribusi Barang Keluar',
            'stok_kritis'      => '4. Laporan Ambang Batas Keselamatan (Restock Alert)',
            'fast_moving'      => '5. Laporan Kinerja Klaster: Fast Moving Items',
            'slow_moving'      => '6. Laporan Kinerja Klaster: Slow Moving Items',
            'dead_stock'       => '7. Laporan Indikasi Kerugian: Dead Stock Items',
            'retur_audit'      => '8. Laporan Audit Pengembalian (Retur Barang)',
            'kinerja_supplier' => '9. Laporan Jejak Rekam Kinerja Pemasok',
            'valuasi_aset'     => '10. Laporan Nilai Valuasi Aset Gudang Terkini',
            'system_log'       => '11. Laporan Jejak Audit Aktivitas Pengguna'
        ];

        $data['judul_laporan'] = $mapJudul[$tipe] ?? 'Laporan Manajerial Logistik';
        $data['tanggal_cetak'] = date('d F Y - H:i:s');
        $data['pencetak']      = session()->get('nama_lengkap') ?? 'Administrator';
        $data['role']          = session()->get('role') ?? 'Admin';

        switch ($tipe) {
            case 'master_inventori':
                $data['laporan'] = $db->table('tb_barang b')->select('b.kode_barang AS "Kode SKU", b.nama_barang AS "Identitas Produk", k.nama_kategori AS "Kategori", b.stok_aktual AS "Stok Tersedia"')->join('tb_kategori k', 'k.id_kategori = b.id_kategori', 'left')->get()->getResultArray();
                break;
            case 'barang_masuk':
                $data['laporan'] = $db->table('tb_masuk m')->select('m.tanggal_masuk AS "Waktu Penerimaan", b.kode_barang AS "SKU", b.nama_barang AS "Nama Barang", s.nama_supplier AS "Pemasok", m.qty_masuk AS "Volume Masuk"')->join('tb_barang b', 'b.id_barang = m.id_barang')->join('tb_supplier s', 's.id_supplier = m.id_supplier')->orderBy('m.tanggal_masuk', 'DESC')->get()->getResultArray();
                break;
            case 'barang_keluar':
                $data['laporan'] = $db->table('tb_keluar k')->select('k.tanggal_keluar AS "Waktu Distribusi", b.kode_barang AS "SKU", b.nama_barang AS "Nama Barang", c.nama_customer AS "Tujuan/Customer", k.qty_keluar AS "Volume Keluar"')->join('tb_barang b', 'b.id_barang = k.id_barang')->join('tb_customer c', 'c.id_customer = k.id_customer')->orderBy('k.tanggal_keluar', 'DESC')->get()->getResultArray();
                break;
            case 'stok_kritis':
                $data['laporan'] = $db->table('tb_barang')->select('kode_barang AS "Kode SKU", nama_barang AS "Nama Barang", stok_minimum AS "Ambang Batas Kritis", stok_aktual AS "Sisa Stok Aktual"')->where('stok_aktual <= stok_minimum')->get()->getResultArray();
                break;
            case 'fast_moving':
                $data['laporan'] = $db->table('tb_klaster_kmeans k')->select('b.kode_barang AS "SKU", b.nama_barang AS "Nama Produk", k.velocity_score AS "Skor Velositas", b.stok_aktual AS "Stok Saat Ini"')->join('tb_barang b', 'b.id_barang = k.id_barang')->where('k.label_klaster', 'Fast Moving')->orderBy('k.velocity_score', 'DESC')->get()->getResultArray();
                break;
            case 'slow_moving':
                $data['laporan'] = $db->table('tb_klaster_kmeans k')->select('b.kode_barang AS "SKU", b.nama_barang AS "Nama Produk", k.velocity_score AS "Skor Velositas", b.stok_aktual AS "Stok Menumpuk"')->join('tb_barang b', 'b.id_barang = k.id_barang')->where('k.label_klaster', 'Slow Moving')->get()->getResultArray();
                break;
            case 'dead_stock':
                $data['laporan'] = $db->table('tb_klaster_kmeans k')->select('b.kode_barang AS "SKU", b.nama_barang AS "Nama Produk", b.harga_beli AS "Harga Satuan (Rp)", b.stok_aktual AS "Stok Macet"')->join('tb_barang b', 'b.id_barang = k.id_barang')->where('k.label_klaster', 'Dead Stock')->get()->getResultArray();
                break;
            case 'retur_audit':
                $data['laporan'] = $db->table('tb_retur r')->select('r.tanggal_retur AS "Waktu Anomali", b.nama_barang AS "Produk Terkait", r.qty_retur AS "Volume", r.alasan AS "Keterangan", r.aksi_stok AS "Tindakan Sistem"')->join('tb_barang b', 'b.id_barang = r.id_barang')->orderBy('r.tanggal_retur', 'DESC')->get()->getResultArray();
                break;
            case 'kinerja_supplier':
                // Perbaikan: Alias tidak menggunakan spasi pada orderBy
                $data['laporan'] = $db->table('tb_masuk m')
                                      ->select('s.nama_supplier AS "Identitas Pemasok", COUNT(m.id_masuk) AS "Frekuensi Transaksi", SUM(m.qty_masuk) AS total_volume_pasokan')
                                      ->join('tb_supplier s', 's.id_supplier = m.id_supplier')
                                      ->groupBy('m.id_supplier')
                                      ->orderBy('total_volume_pasokan', 'DESC')
                                      ->get()->getResultArray();
                
                // Kembalikan nama alias kolom ke bentuk string berspasi (opsional) agar tampilan pada view cetak_pdf sama
                if(!empty($data['laporan'])) {
                    foreach($data['laporan'] as &$row) {
                        $row['Total Volume Pasokan'] = $row['total_volume_pasokan'];
                        unset($row['total_volume_pasokan']);
                    }
                }
                break;
            case 'valuasi_aset':
                $data['laporan'] = $db->table('tb_barang')->select('kode_barang AS "SKU", nama_barang AS "Nama Produk", stok_aktual AS "Volume Aset", harga_beli AS "Nilai Satuan", (stok_aktual * harga_beli) AS "Total Nilai Kapital"')->get()->getResultArray();
                break;
            case 'system_log':
                $data['laporan'] = $db->table('tb_log_aktivitas l')->select('l.waktu AS "Timestamp", u.nama_lengkap AS "Operator/User", l.modul AS "Modul Sistem", l.aksi AS "Jejak Aktivitas"')->join('tb_users u', 'u.id_user = l.id_user')->orderBy('l.waktu', 'DESC')->get()->getResultArray();
                break;
            default:
                $data['laporan'] = [];
        }

        // ==========================================
        // PROSES RENDER DOMPDF
        // ==========================================
        $html = view('laporan/cetak_pdf', $data);

        $dompdf = new \Dompdf\Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); 
        $dompdf->render();

        $namaFile = "DOC_" . strtoupper($tipe) . "_" . date('Ymd_Hi') . ".pdf";
        return $dompdf->stream($namaFile, ["Attachment" => false]); 
    }
}