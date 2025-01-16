<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LaporanKebakaranModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $laporanModel = new LaporanKebakaranModel();
        $data = [
            'total_laporan' => $laporanModel->countAll(),
            'laporan_pending' => $laporanModel->where('status', 'pending')->countAllResults(),
            'laporan_proses' => $laporanModel->where('status', 'proses')->countAllResults(),
            'laporan_selesai' => $laporanModel->where('status', 'selesai')->countAllResults(),
            'laporan_terbaru' => $laporanModel->orderBy('created_at', 'DESC')->limit(5)->find()
        ];
        
        return view('admin/dashboard', $data);
    }
} 