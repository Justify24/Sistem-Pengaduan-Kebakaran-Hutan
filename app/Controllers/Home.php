<?php

namespace App\Controllers;

use App\Models\LaporanKebakaranModel;

class Home extends BaseController
{
    public function index()
    {
        $laporanModel = new LaporanKebakaranModel();
        $data = [
            'laporan_terbaru' => $laporanModel->orderBy('created_at', 'DESC')
                                             ->limit(5)
                                             ->find(),
            'total_laporan' => $laporanModel->countAll(),
            'laporan_selesai' => $laporanModel->where('status', 'selesai')
                                             ->countAllResults()
        ];
        
        return view('home', $data);
    }

    public function buatLaporan()
    {
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'nama_pelapor' => 'required|min_length[3]',
                'nomor_hp' => 'required|min_length[10]',
                'latitude' => 'required|decimal',
                'longitude' => 'required|decimal',
                'lokasi_detail' => 'required',
                'deskripsi' => 'required',
                'gambar' => 'uploaded[gambar]|max_size[gambar,4096]|is_image[gambar]'
            ];

            if ($this->validate($rules)) {
                $file = $this->request->getFile('gambar');
                $fileName = $file->getRandomName();
                $file->move(ROOTPATH . 'public/uploads/laporan', $fileName);

                $laporanModel = new LaporanKebakaranModel();
                $data = [
                    'nama_pelapor' => $this->request->getPost('nama_pelapor'),
                    'nomor_hp' => $this->request->getPost('nomor_hp'),
                    'latitude' => $this->request->getPost('latitude'),
                    'longitude' => $this->request->getPost('longitude'),
                    'lokasi_detail' => $this->request->getPost('lokasi_detail'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'gambar' => $fileName,
                    'status' => 'pending'
                ];

                if ($laporanModel->insert($data)) {
                    return redirect()->to('/')->with('success', 'Laporan berhasil dikirim. Petugas akan segera menindaklanjuti.');
                }
            }
        }

        return view('buat_laporan');
    }

    public function history()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $laporanModel = new LaporanKebakaranModel();
        $data['laporan'] = $laporanModel->where('user_id', session()->get('user_id'))
                                      ->orderBy('created_at', 'DESC')
                                      ->findAll();

        return view('history', $data);
    }
}
