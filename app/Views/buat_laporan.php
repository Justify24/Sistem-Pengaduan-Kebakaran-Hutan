<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporkan Kebakaran Hutan - SIPALHAN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
</head>
<body>
    <!-- Navbar dari home.php -->
    
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0">Laporkan Kebakaran Hutan</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('laporan/simpan') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            
                            <?php if (session()->has('error')): ?>
                                <div class="alert alert-danger">
                                    <?php 
                                    $errors = session('error');
                                    if (is_array($errors)) {
                                        foreach ($errors as $error) {
                                            echo $error . '<br>';
                                        }
                                    } else {
                                        echo $errors;
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">Data Pelapor</label>
                                <input type="text" class="form-control" name="nama_pelapor" placeholder="Nama Lengkap" required>
                            </div>
                            
                            <div class="mb-3">
                                <input type="tel" class="form-control" name="nomor_hp" placeholder="Nomor HP/WhatsApp" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Lokasi Kebakaran</label>
                                <div id="map" style="height: 300px;" class="mb-2"></div>
                                <input type="hidden" name="latitude" id="latitude" required>
                                <input type="hidden" name="longitude" id="longitude" required>
                                <input type="text" class="form-control" name="lokasi_detail" placeholder="Detail Lokasi (nama daerah, patokan)" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Kejadian</label>
                                <textarea class="form-control" name="deskripsi" rows="4" placeholder="Jelaskan kondisi kebakaran" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Foto Kejadian</label>
                                <input type="file" class="form-control" name="gambar" accept="image/*" required>
                            </div>

                            <button type="submit" class="btn btn-danger">Kirim Laporan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-2.5489, 118.0149], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        var marker;
        
        // Event ketika peta diklik
        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            
            // Update input fields
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });

        // Coba dapatkan lokasi user
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                map.setView([position.coords.latitude, position.coords.longitude], 13);
            });
        }
    </script>
</body>
</html> 