<?php

namespace App\Controllers;

use App\Models\AnalitikModel;

// Memanggil Library Machine Learning sesuai instruksi dokumen
use Phpml\Clustering\KMeans;

class Analitik extends BaseController
{
    public function generate_klasterisasi_kmeans()
    {
        $analitikModel = new AnalitikModel();

        // 1. Menarik dataset dari db_inventori
        $data_mentah = $analitikModel->get_historis_velocity();

        if (empty($data_mentah)) {
            return "Dataset kosong, tidak bisa melakukan klasterisasi.";
        }

        // 2. Format ulang data untuk algoritma PHP-ML (Array of Arrays)
        // Kita gunakan [velocity, stok_aktual] sebagai titik koordinat matriks
        $samples = [];
        $mapping_id = []; // Untuk melacak ID barang setelah di-klaster

        foreach ($data_mentah as $index => $row) {
            $samples[] = [(float)$row['velocity'], (float)$row['stok_aktual']];
            $mapping_id[$index] = [
                'id' => $row['id_barang'],
                'velocity' => $row['velocity']
            ];
        }

        // 3. Inisiasi K-Means untuk 3 Klaster
        $kmeans = new KMeans(3);
        $clusters = $kmeans->cluster($samples);

        // 4. Pelabelan Logis (Fast, Slow, Dead)
        // K-Means murni hanya membagi array menjadi 0, 1, 2. Kita harus melabelinya
        // berdasarkan nilai velocity rata-rata dari masing-masing klaster.
        $labeled_clusters = $this->tentukan_label_klaster($clusters);

        // 5. Menyimpan hasil kalkulasi kembali ke tb_klaster_kmeans
        foreach ($labeled_clusters as $label => $cluster_data) {
            foreach ($cluster_data as $titik_koordinat) {
                // Mencari ID barang asli berdasarkan titik sampel
                $index_asli = array_search($titik_koordinat, $samples);
                $id_barang = $mapping_id[$index_asli]['id'];
                $velocity = $mapping_id[$index_asli]['velocity'];

                $analitikModel->update_hasil_klaster($id_barang, $velocity, $label);
            }
        }

        return "Algoritma K-Means berhasil merestrukturisasi status barang.";
    }

    // Fungsi internal untuk memetakan klaster 0,1,2 menjadi teks label
    private function tentukan_label_klaster($clusters)
    {
        $rata_rata = [];
        foreach ($clusters as $key => $cluster) {
            // Hitung rata-rata kecepatan keluar (kolom indeks 0) di klaster ini
            $total_vel = array_sum(array_column($cluster, 0));
            $count = count($cluster);
            $rata_rata[$key] = $count > 0 ? ($total_vel / $count) : 0;
        }

        // Urutkan klaster berdasarkan velocity: Terendah ke Tertinggi
        asort($rata_rata);
        $keys_sorted = array_keys($rata_rata);

        // Labeling: Yang paling jarang keluar = Dead Stock, paling sering = Fast Moving
        $hasil = [
            'Dead Stock' => $clusters[$keys_sorted[0]],
            'Slow Moving' => $clusters[$keys_sorted[1]],
            'Fast Moving' => $clusters[$keys_sorted[2]],
        ];

        return $hasil;
    }
}
