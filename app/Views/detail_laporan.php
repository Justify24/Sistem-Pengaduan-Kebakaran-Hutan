<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - SIPALHAN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        
        .timeline-item {
            padding-left: 30px;
            position: relative;
            margin-bottom: 20px;
        }
        
        .timeline-item:before {
            content: '';
            position: absolute;
            left: 12px;
            top: 25px;
            height: 100%;
            width: 2px;
            background-color: #e9ecef;
        }
        
        .timeline-item:last-child:before {
            display: none;
        }
        
        .timeline-item i {
            position: absolute;
            left: 0;
            top: 4px;
            font-size: 24px;
        }

        .status-badge {
            font-size: 1rem;
            padding: 8px 16px;
        }

        .detail-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .map-container {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .photo-container {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .photo-container img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .info-box {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .info-box i {
            font-size: 1.2rem;
            margin-right: 10px;
            color: #6c757d;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-fire me-2"></i>
                SIPALHAN
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="bi bi-house-door me-1"></i>
                            Kembali ke Beranda
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-lg-8">
                <!-- Header Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title">
                            <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                            Laporan Kebakaran Hutan
                        </h3>
                        <div class="d-flex align-items-center mt-3">
                            <span class="status-badge badge bg-<?= $laporan['status'] == 'Menunggu' ? 'warning' : 
                                ($laporan['status'] == 'Diproses' ? 'info' : 'success') ?>">
                                <i class="bi bi-<?= $laporan['status'] == 'Menunggu' ? 'clock' : 
                                    ($laporan['status'] == 'Diproses' ? 'arrow-repeat' : 'check-circle') ?> me-1"></i>
                                <?= $laporan['status'] ?>
                            </span>
                            <span class="ms-3 text-muted">
                                <i class="bi bi-calendar-event me-1"></i>
                                <?= date('d/m/Y H:i', strtotime($laporan['created_at'])) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Photo Section -->
                <?php if($laporan['foto']): ?>
                <div class="photo-container mb-4">
                    <img src="<?= base_url('uploads/kebakaran/' . $laporan['foto']) ?>" 
                         class="img-fluid" 
                         alt="Foto Kebakaran">
                </div>
                <?php endif; ?>

                <!-- Location Section -->
                <div class="detail-section">
                    <h4 class="mb-3">
                        <i class="bi bi-geo me-2"></i>
                        Lokasi Kebakaran
                    </h4>
                    <div class="info-box mb-3">
                        <p class="mb-0"><strong>Alamat:</strong> <?= esc($laporan['lokasi_kebakaran']) ?></p>
                    </div>
                    <div class="map-container">
                        <div id="map" style="height: 400px;"></div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="detail-section">
                    <h4 class="mb-3">
                        <i class="bi bi-card-text me-2"></i>
                        Deskripsi Kejadian
                    </h4>
                    <div class="info-box">
                        <p class="mb-0"><?= nl2br(esc($laporan['deskripsi'])) ?></p>
                    </div>
                </div>

                <?php if(!empty($laporan['keterangan'])): ?>
                <div class="detail-section">
                    <h4 class="mb-3">
                        <i class="bi bi-info-circle me-2"></i>
                        Keterangan Update
                    </h4>
                    <div class="info-box">
                        <p class="mb-0"><?= nl2br(esc($laporan['keterangan'])) ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Reporter Info -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-person-fill me-2"></i>
                            Informasi Pelapor
                        </h5>
                        <div class="info-box">
                            <p class="mb-2">
                                <i class="bi bi-person"></i>
                                <?= esc($laporan['nama_pelapor']) ?>
                            </p>
                            <p class="mb-0">
                                <i class="bi bi-telephone"></i>
                                <?= esc($laporan['no_telepon']) ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Status Timeline -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-clock-history me-2"></i>
                            Status Penanganan
                        </h5>
                        <div class="timeline">
                            <div class="timeline-item">
                                <i class="bi bi-circle-fill text-<?= $laporan['status'] == 'Menunggu' ? 'warning' : 'success' ?>"></i>
                                <div class="ms-2">
                                    <h6 class="mb-1">Laporan Diterima</h6>
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($laporan['created_at'])) ?>
                                    </small>
                                </div>
                            </div>
                            
                            <?php if($laporan['status'] != 'Menunggu'): ?>
                            <div class="timeline-item">
                                <i class="bi bi-circle-fill text-<?= $laporan['status'] == 'Diproses' ? 'info' : 'success' ?>"></i>
                                <div class="ms-2">
                                    <h6 class="mb-1">Sedang Diproses</h6>
                                    <small class="text-muted">Dalam penanganan petugas</small>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($laporan['status'] == 'Selesai'): ?>
                            <div class="timeline-item">
                                <i class="bi bi-circle-fill text-success"></i>
                                <div class="ms-2">
                                    <h6 class="mb-1">Selesai Ditangani</h6>
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($laporan['updated_at'])) ?>
                                    </small>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([<?= $laporan['latitude'] ?>, <?= $laporan['longitude'] ?>], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        
        // Tambah marker
        L.marker([<?= $laporan['latitude'] ?>, <?= $laporan['longitude'] ?>])
         .bindPopup("<?= esc($laporan['lokasi_kebakaran']) ?>")
         .addTo(map);
    </script>
</body>
</html> 