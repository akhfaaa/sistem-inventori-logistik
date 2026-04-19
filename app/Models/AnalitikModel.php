<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalitikModel extends Model
{
    protected $table            = 'tb_klaster_kmeans';
    protected $primaryKey       = 'id_klaster';
    protected $allowedFields    = ['id_barang', 'velocity_score', 'label_klaster'];

    public function get_historis_velocity()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tb_barang b');
        $builder->select('b.id_barang, b.stok_aktual, IFNULL(SUM(k.qty_keluar), 0) as velocity');
        $builder->join('tb_keluar k', 'b.id_barang = k.id_barang', 'left');
        $builder->groupBy('b.id_barang');
        
        return $builder->get()->getResultArray();
    }
}