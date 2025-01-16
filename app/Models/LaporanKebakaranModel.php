<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanKebakaranModel extends Model
{
    protected $table = 'laporan_kebakaran';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'nama_pelapor',
        'no_telepon',
        'lokasi_kebakaran',
        'latitude',
        'longitude',
        'deskripsi',
        'foto',
        'status',
        'keterangan'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
} 