<?php

namespace App\Models;
use CodeIgniter\Model;

class SpkModel extends Model
{
    // Menghitung rekomendasi menggunakan algoritma SAW
    public function hitungSAW()
    {
        $db = \Config\Database::connect();
        
        // 1. Ambil data nilai mentah beserta nama supplier
        $suppliers = $db->table('tb_nilai_supplier n')
                        ->select('n.*, s.nama_supplier')
                        ->join('tb_supplier s', 's.id_supplier = n.id_supplier')
                        ->get()->getResultArray();

        if (empty($suppliers)) return [];

        // 2. Tentukan Bobot (W) - Total harus 1.0 (100%)
        // Harga: 30%, Kecepatan: 25%, Kualitas: 30%, Jarak: 15%
        $bobot = ['c1' => 0.30, 'c2' => 0.25, 'c3' => 0.30, 'c4' => 0.15];

        // 3. Cari Nilai Max (untuk Benefit) dan Min (untuk Cost)
        $minC1 = min(array_column($suppliers, 'c1_harga')); // Cost
        $maxC2 = max(array_column($suppliers, 'c2_kecepatan')); // Benefit
        $maxC3 = max(array_column($suppliers, 'c3_kualitas')); // Benefit
        $minC4 = min(array_column($suppliers, 'c4_jarak')); // Cost

        $hasilAkhir = [];

        // 4. Proses Normalisasi (R) dan Perhitungan Preferensi (V)
        foreach ($suppliers as $s) {
            // Rumus Normalisasi SAW
            $r_c1 = $minC1 / $s['c1_harga']; // Cost = Min / Nilai
            $r_c2 = $s['c2_kecepatan'] / $maxC2; // Benefit = Nilai / Max
            $r_c3 = $s['c3_kualitas'] / $maxC3;  // Benefit = Nilai / Max
            $r_c4 = $minC4 / $s['c4_jarak'];     // Cost = Min / Nilai

            // Rumus Preferensi (V = R * W)
            $skor_akhir = ($r_c1 * $bobot['c1']) + 
                          ($r_c2 * $bobot['c2']) + 
                          ($r_c3 * $bobot['c3']) + 
                          ($r_c4 * $bobot['c4']);

            $hasilAkhir[] = [
                'id_supplier'   => $s['id_supplier'],
                'nama_supplier' => $s['nama_supplier'],
                'skor_saw'      => round($skor_akhir, 3) // Bulatkan 3 desimal
            ];
        }

        // 5. Urutkan dari skor tertinggi (terbaik) ke terendah
        usort($hasilAkhir, function($a, $b) {
            return $b['skor_saw'] <=> $a['skor_saw'];
        });

        return $hasilAkhir;
    }
}