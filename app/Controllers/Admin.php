<?php

namespace App\Controllers;

use App\Models\LaporanKebakaranModel;

class Admin extends BaseController
{
    protected $laporanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanKebakaranModel();
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard Admin',
            'total_aduan' => $this->laporanModel->countAll(),
            'menunggu' => $this->laporanModel->where('status', 'Menunggu')->countAllResults(),
            'diproses' => $this->laporanModel->where('status', 'Diproses')->countAllResults(),
            'selesai' => $this->laporanModel->where('status', 'Selesai')->countAllResults(),
            'laporan_terbaru' => $this->laporanModel->orderBy('created_at', 'DESC')->limit(5)->find()
        ];

        return view('admin/dashboard', $data);
    }

    public function laporan()
    {
        $data = [
            'title' => 'Daftar Laporan Kebakaran',
            'laporan' => $this->laporanModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/laporan/index', $data);
    }

    public function updateStatus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $status = $this->request->getPost('status');
            $keterangan = $this->request->getPost('keterangan');

            $data = [
                'status' => $status,
                'keterangan' => $keterangan,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            try {
                $this->laporanModel->update($id, $data);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Status berhasil diperbarui'
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui status: ' . $e->getMessage()
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request'
        ]);
    }

    public function peta()
    {
        $data['laporan'] = $this->laporanModel->findAll();
        return view('admin/peta', $data);
    }

    public function statistik()
    {
        // Hitung total dan status
        $data['total_laporan'] = $this->laporanModel->countAll();
        $data['menunggu'] = $this->laporanModel->where('status', 'Menunggu')->countAllResults();
        $data['diproses'] = $this->laporanModel->where('status', 'Diproses')->countAllResults();
        $data['selesai'] = $this->laporanModel->where('status', 'Selesai')->countAllResults();

        // Hitung laporan bulanan
        $tahun = date('Y');
        $data['laporan_bulanan'] = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $bulan = sprintf("%02d", $i);
            $total = $this->laporanModel
                ->where("DATE_FORMAT(created_at, '%Y-%m')", "$tahun-$bulan")
                ->countAllResults();
            
            $data['laporan_bulanan'][] = $total;
        }

        return view('admin/statistik', $data);
    }
} 