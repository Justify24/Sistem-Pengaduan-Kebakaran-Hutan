<?php

namespace App\Controllers;

class Laporan extends BaseController
{
    protected $laporanModel;

    public function __construct()
    {
        $this->laporanModel = new \App\Models\LaporanKebakaranModel();
    }

    public function buatLaporan()
    {
        return view('buat_laporan');
    }

    public function simpan()
    {
        // Validasi input
        $rules = [
            'nama_pelapor' => 'required',
            'nomor_hp' => 'required',
            'lokasi_detail' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        // Handle file upload
        $gambar = $this->request->getFile('gambar');
        $namaGambar = $gambar->getRandomName();
        $gambar->move('uploads/kebakaran', $namaGambar);

        // Siapkan data
        $data = [
            'nama_pelapor' => $this->request->getPost('nama_pelapor'),
            'no_telepon' => $this->request->getPost('nomor_hp'),
            'lokasi_kebakaran' => $this->request->getPost('lokasi_detail'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'foto' => $namaGambar,
            'status' => 'Menunggu'
        ];

        // Simpan ke database
        try {
            $this->laporanModel->insert($data);
            return redirect()->to('/')->with('success', 'Laporan berhasil dikirim');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan laporan');
        }
    }

    public function detail($id)
    {
        $laporan = $this->laporanModel->find($id);
        
        if (!$laporan) {
            return redirect()->to('/')->with('error', 'Laporan tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Laporan Kebakaran',
            'laporan' => $laporan
        ];

        return view('detail_laporan', $data);
    }
} 