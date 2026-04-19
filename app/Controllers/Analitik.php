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
            'list_barang' => $db->table('tb_klaster_kmeans k')
                               ->select('k.*, b.nama_barang')
                               ->join('tb_barang b', 'b.id_barang = k.id_barang')
                               ->get()->getResultArray(),
            'rekap' => $db->table('tb_klaster_kmeans')
                          ->select('label_klaster, COUNT(*) as total')
                          ->groupBy('label_klaster')->get()->getResultArray()
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
        $analitikModel = new AnalitikModel();
        $data_mentah = $analitikModel->get_historis_velocity();

        // K-Means butuh minimal data sejumlah klaster (3)
        if (count($data_mentah) < 3) {
            return;
        }

        $samples = [];
        $ids = [];

        foreach ($data_mentah as $row) {
            $samples[] = [(float)$row['velocity'], (float)$row['stok_aktual']];
            $ids[] = $row['id_barang'];
        }

        // Eksekusi Algoritma
        $kmeans = new KMeans(3);
        $clusters = $kmeans->cluster($samples);

        $db = \Config\Database::connect();

        foreach ($clusters as $index_klaster => $cluster_points) {
            foreach ($cluster_points as $point) {
                // Cari ID barang yang sesuai dengan koordinat point
                $key = array_search($point, $samples);
                $id_barang = $ids[$key];
                $velocity = $point[0];

                // Penentuan Label (Urutan default K-Means)
                $label = 'Klaster ' . ($index_klaster + 1);
                if ($index_klaster == 0) $label = 'Dead Stock';
                if ($index_klaster == 1) $label = 'Slow Moving';
                if ($index_klaster == 2) $label = 'Fast Moving';

                // Brute Force SQL: Insert jika baru, Update jika ID sudah ada
                $sql = "INSERT INTO tb_klaster_kmeans (id_barang, velocity_score, label_klaster) 
                        VALUES (?, ?, ?) 
                        ON DUPLICATE KEY UPDATE 
                        velocity_score = VALUES(velocity_score), 
                        label_klaster = VALUES(label_klaster)";
                
                $db->query($sql, [$id_barang, $velocity, $label]);
            }
        }
    }
}