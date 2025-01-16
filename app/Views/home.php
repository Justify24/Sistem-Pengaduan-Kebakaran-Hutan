<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pelaporan Kebakaran Hutan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?auto=format&fit=crop&w=2000');
            background-size: cover;
            background-position: center;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .about img {
            content: url('https://images.unsplash.com/photo-1611273426858-450d8e3c9fce?auto=format&fit=crop&w=1000');
        }

        .about {
            background-color: #f8f9fa;
            padding: 80px 0;
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 40px 0;
        }

        .navbar {
            background-color: rgba(33, 37, 41, 0.9) !important;
            backdrop-filter: blur(10px);
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            transition: all 0.3s;
        }

        .btn-danger:hover {
            background-color: #bb2d3b;
            border-color: #bb2d3b;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">SIPALHAN</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#peta">Peta Kebakaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#history">Riwayat Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/buat-laporan" class="btn btn-danger px-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            LAPORKAN KEBAKARAN
                        </a>
                    </li>
                    <?php if(session()->get('role') == 'admin'): ?>
                        <li class="nav-item ms-2">
                            <a class="btn btn-outline-light" href="/admin/dashboard">
                                Dashboard Admin
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-4 fw-bold mb-4">Laporkan Kebakaran Hutan Sekarang!</h1>
                    <p class="lead mb-4">
                        Setiap menit sangat berharga untuk menyelamatkan hutan kita. 
                        Laporkan segera jika Anda melihat kebakaran hutan!
                    </p>
                    <div class="d-grid gap-2 d-sm-flex">
                        <a href="/buat-laporan" class="btn btn-danger btn-lg px-5 py-3">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Buat Laporan Sekarang
                        </a>
                        <a href="#peta" class="btn btn-outline-light btn-lg px-5 py-3">
                            <i class="bi bi-map-fill me-2"></i>
                            Lihat Peta Kebakaran
                        </a>
                    </div>
                    <div class="mt-4 text-white-50">
                        <p class="mb-1">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Tidak perlu login atau registrasi
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Proses pelaporan cepat dan mudah
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Ditangani langsung oleh petugas
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="text-center">
                        <div class="card bg-white bg-opacity-10 p-4">
                            <div class="card-body">
                                <h3 class="text-white mb-3">Statistik Laporan</h3>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <div class="border border-light rounded p-3">
                                            <h2 class="text-white"><?= $total_laporan ?></h2>
                                            <p class="mb-0 text-white-50">Total Laporan</p>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="border border-light rounded p-3">
                                            <h2 class="text-white"><?= $laporan_selesai ?></h2>
                                            <p class="mb-0 text-white-50">Kasus Selesai</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-start mt-3">
                                    <p class="text-white-50 mb-2">
                                        <i class="bi bi-clock-fill me-2"></i>
                                        Laporan Terakhir:
                                    </p>
                                    <?php foreach(array_slice($laporan_terbaru, 0, 2) as $laporan): ?>
                                        <div class="bg-white bg-opacity-10 rounded p-2 mb-2">
                                            <small class="text-white">
                                                <?= $laporan['lokasi_kebakaran'] ?>
                                                <br>
                                                <span class="text-white-50">
                                                    <?= date('d/m/Y H:i', strtotime($laporan['created_at'])) ?>
                                                </span>
                                            </small>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Peta -->
    <section class="py-5 bg-light" id="peta">
        <div class="container">
            <h2 class="text-center mb-4">Peta Kebakaran Hutan</h2>
            <div id="map" style="height: 500px;" class="rounded shadow"></div>
        </div>
    </section>

    <!-- History -->
    <section class="py-5" id="history">
        <div class="container">
            <h2 class="text-center mb-4">Laporan Terbaru</h2>
            <div class="row">
                <?php foreach($laporan_terbaru as $laporan): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if($laporan['foto']): ?>
                            <img src="/uploads/kebakaran/<?= $laporan['foto'] ?>" class="card-img-top" alt="Foto Kebakaran">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= $laporan['lokasi_kebakaran'] ?></h5>
                            <p class="card-text"><?= substr($laporan['deskripsi'], 0, 100) ?>...</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <?= date('d/m/Y', strtotime($laporan['created_at'])) ?>
                                </small>
                                <a href="<?= base_url('laporan/detail/' . $laporan['id']) ?>" class="btn btn-outline-primary btn-sm">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- About -->
    <section class="about" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>Tentang SIPALHAN</h2>
                    <p class="lead">Sistem Pelaporan Kebakaran Hutan (SIPALHAN) adalah platform yang memungkinkan masyarakat untuk melaporkan kejadian kebakaran hutan secara real-time.</p>
                    <p>Fitur utama:</p>
                    <ul>
                        <li>Pelaporan cepat dengan lokasi akurat</li>
                        <li>Tracking status penanganan</li>
                        <li>Pemetaan titik kebakaran</li>
                        <li>Riwayat laporan lengkap</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <img src="/assets/images/about.jpg" alt="About" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>SIPALHAN</h5>
                    <p>Sistem Pelaporan Kebakaran Hutan</p>
                </div>
                <div class="col-md-4">
                    <h5>Link Penting</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Cara Melapor</a></li>
                        <li><a href="#" class="text-white">FAQ</a></li>
                        <li><a href="#" class="text-white">Kontak Darurat</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled">
                        <li>Email: info@sipalhan.id</li>
                        <li>Telp: (021) 1234567</li>
                        <li>Alamat: Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4">
            <div class="text-center">
                <p>&copy; <?= date('Y') ?> SIPALHAN. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-2.5489, 118.0149], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // Tambahkan marker untuk setiap titik kebakaran
        <?php foreach($laporan_terbaru as $laporan): ?>
        L.marker([<?= $laporan['latitude'] ?>, <?= $laporan['longitude'] ?>])
         .bindPopup(`
            <strong><?= $laporan['lokasi_kebakaran'] ?></strong><br>
            <small>Status: <?= ucfirst($laporan['status']) ?></small>
         `)
         .addTo(map);
        <?php endforeach; ?>

        // Smooth scroll untuk navigasi
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html> 