<?php

namespace App\Controllers;

use App\Models\AnalitikModel;
use Phpml\Clustering\KMeans;

class Analitik extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        $data = [
            'title' => 'Analitik K-Means | Inventori',
            
            // 1. Data untuk Tabel Bawah
            'list_barang' => $db->table('tb_klaster_kmeans k')
                               ->select('k.*, b.nama_barang')
                               ->join('tb_barang b', 'b.id_barang = k.id_barang')
                               ->get()->getResultArray(),
                               
            // 2. Data untuk Kartu KPI (Total per Klaster)
            'rekap' => $db->table('tb_klaster_kmeans')
                           ->select('label_klaster, COUNT(*) as total')
                           ->groupBy('label_klaster')->get()->getResultArray(),
                           
            // 3. Kargo Data Baru Khusus untuk Grafik Spatial Intelligence
            'chart_spasial' => $db->table('tb_klaster_kmeans k')
                                 ->select('k.velocity_score as x, b.stok_aktual as y, k.label_klaster, b.nama_barang')
                                 ->join('tb_barang b', 'b.id_barang = k.id_barang')
                                 ->get()->getResultArray()
        ];
        
        return view('analitik/index', $data);
    }

    public function proses()
    {
        $this->generate_klasterisasi_kmeans();
        return redirect()->to('/analitik');
    }

    private function generate_klasterisasi_kmeans()
    {
        // Panggil class secara absolut untuk menghindari error namespace
        $analitikModel = new \App\Models\AnalitikModel();
        $data_mentah = $analitikModel->get_historis_velocity();

        // Validasi: Pastikan ada minimal 3 data berbeda agar AI bisa bekerja
        if (count($data_mentah) < 3) {
            return; // Hentikan proses jika data terlalu sedikit
        }

        $samples = [];
        $ids = [];

        foreach ($data_mentah as $row) {
            $samples[] = [(float)$row['velocity'], (float)$row['stok_aktual']];
            $ids[] = $row['id_barang'];
        }

        // Eksekusi Algoritma K-Means AI
        $kmeans = new \Phpml\Clustering\KMeans(3);
        $clusters = $kmeans->cluster($samples);

        $db = \Config\Database::connect();

        // 1. Logika Pelabelan AI yang Aman (Tahan terhadap Array Kosong)
        $cluster_averages = [];
        foreach ($clusters as $index => $points) {
            $sum_velocity = 0;
            foreach ($points as $p) {
                $sum_velocity += $p[0];
            }
            $cluster_averages[$index] = count($points) > 0 ? ($sum_velocity / count($points)) : 0;
        }

        // Urutkan nilai rata-rata dari terkecil ke terbesar
        asort($cluster_averages);

        // Pemetaan dinamis (Anti "Undefined Array Key")
        $label_names = ['Dead Stock', 'Slow Moving', 'Fast Moving'];
        $label_mapping = [];
        $i = 0;
        foreach ($cluster_averages as $original_index => $avg) {
            $label_mapping[$original_index] = $label_names[$i] ?? 'Fast Moving';
            $i++;
        }

        $temp_samples = $samples;

        // 2. Eksekusi ke Database yang Aman dengan Query Builder CI4
        foreach ($clusters as $index_klaster => $cluster_points) {
            // Ambil label yang sesuai, jika error fallback ke 'Slow Moving'
            $label = $label_mapping[$index_klaster] ?? 'Slow Moving';

            foreach ($cluster_points as $point) {
                $key = array_search($point, $temp_samples);

                if ($key !== false) {
                    $id_barang = $ids[$key];
                    $velocity = $point[0];

                    // Cegah bug duplikasi ID
                    unset($temp_samples[$key]);

                    // Pengecekan data murni gaya CodeIgniter 4 (Bebas SQL Error)
                    $cek_data = $db->table('tb_klaster_kmeans')
                        ->where('id_barang', $id_barang)
                        ->countAllResults();

                    if ($cek_data > 0) {
                        // Jika data sudah ada, lakukan UPDATE
                        $db->table('tb_klaster_kmeans')
                            ->where('id_barang', $id_barang)
                            ->update([
                                'velocity_score' => $velocity,
                                'label_klaster'  => $label
                            ]);
                    } else {
                        // Jika data baru, lakukan INSERT
                        $db->table('tb_klaster_kmeans')->insert([
                            'id_barang'      => $id_barang,
                            'velocity_score' => $velocity,
                            'label_klaster'  => $label
                        ]);
                    }
                }
            }
        }
    }
}
