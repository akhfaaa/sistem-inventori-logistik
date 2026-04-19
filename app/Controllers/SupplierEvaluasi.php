<?php

namespace App\Controllers;

class SupplierEvaluasi extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Ambil data nilai supplier beserta nama supplier-nya
        $data['evaluasi'] = $db->table('tb_nilai_supplier n')
            ->select('n.*, s.nama_supplier')
            ->join('tb_supplier s', 's.id_supplier = n.id_supplier')
            ->get()->getResultArray();

        // Ambil list supplier yang belum memiliki nilai evaluasi (untuk dropdown tambah)
        $existing_ids = array_column($data['evaluasi'], 'id_supplier');
        $builder = $db->table('tb_supplier');
        if (!empty($existing_ids)) {
            $builder->whereNotIn('id_supplier', $existing_ids);
        }
        $data['supplier_list'] = $builder->get()->getResultArray();

        $data['title'] = "Evaluasi Vendor | SPK SAW";
        return view('supplier_evaluasi/index', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $db->table('tb_nilai_supplier')->insert([
            'id_supplier'  => $this->request->getPost('id_supplier'),
            'c1_harga'     => $this->request->getPost('c1_harga'),
            'c2_kecepatan' => $this->request->getPost('c2_kecepatan'),
            'c3_kualitas'  => $this->request->getPost('c3_kualitas'),
            'c4_jarak'     => $this->request->getPost('c4_jarak'),
        ]);

        $this->tulis_log("Menambah penilaian supplier", "SPK");
        return redirect()->to('/supplierevaluasi')->with('success', 'Data evaluasi berhasil disimpan.');
    }

    public function update()
    {
        $db = \Config\Database::connect();
        $id_supplier = $this->request->getPost('id_supplier');

        $db->table('tb_nilai_supplier')->where('id_supplier', $id_supplier)->update([
            'c1_harga'     => $this->request->getPost('c1_harga'),
            'c2_kecepatan' => $this->request->getPost('c2_kecepatan'),
            'c3_kualitas'  => $this->request->getPost('c3_kualitas'),
            'c4_jarak'     => $this->request->getPost('c4_jarak'),
        ]);

        $this->tulis_log("Memperbarui matriks evaluasi vendor", "SPK");
        return redirect()->to('/supplierevaluasi')->with('success', 'Data evaluasi berhasil diperbarui.');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('tb_nilai_supplier')->where('id_supplier', $id)->delete();
        
        $this->tulis_log("Menghapus penilaian supplier", "SPK");
        return redirect()->to('/supplierevaluasi')->with('success', 'Data berhasil dihapus.');
    }
}