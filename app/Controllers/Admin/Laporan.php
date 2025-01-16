<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LaporanKebakaranModel;

class Laporan extends BaseController
{
    public function index()
    {
        $laporanModel = new LaporanKebakaranModel();
        $data['laporan'] = $laporanModel->select('laporan_kebakaran.*, users.username')
                                      ->join('users', 'users.id = laporan_kebakaran.user_id')
                                      ->orderBy('created_at', 'DESC')
                                      ->findAll();

        return view('admin/laporan/index', $data);
    }

    public function detail($id)
    {
        $laporanModel = new LaporanKebakaranModel();
        $data['laporan'] = $laporanModel->select('laporan_kebakaran.*, users.username')
                                      ->join('users', 'users.id = laporan_kebakaran.user_id')
                                      ->find($id);

        if (empty($data['laporan'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Laporan tidak ditemukan');
        }

        return view('admin/laporan/detail', $data);
    }

    public function updateStatus($id)
    {
        if ($this->request->getMethod() == 'post') {
            $laporanModel = new LaporanKebakaranModel();
            $status = $this->request->getPost('status');

            if (in_array($status, ['pending', 'proses', 'selesai'])) {
                $laporanModel->update($id, ['status' => $status]);
                return redirect()->back()->with('success', 'Status berhasil diperbarui');
            }
        }
        return redirect()->back()->with('error', 'Status tidak valid');
    }
} 