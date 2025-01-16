<?= $this->extend('admin/layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Daftar Laporan Kebakaran</h4>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tabelLaporan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Pelapor</th>
                            <th>No. Telepon</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($laporan as $key => $item): ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></td>
                            <td><?= esc($item['nama_pelapor']) ?></td>
                            <td><?= esc($item['no_telepon']) ?></td>
                            <td><?= esc($item['lokasi_kebakaran']) ?></td>
                            <td>
                                <span class="badge bg-<?= $item['status'] == 'Menunggu' ? 'warning' : 
                                    ($item['status'] == 'Diproses' ? 'info' : 'success') ?>">
                                    <?= $item['status'] ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal<?= $item['id'] ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal<?= $item['id'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal<?= $item['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Laporan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php if($item['foto']): ?>
                                        <div class="mb-3">
                                            <img src="<?= base_url('uploads/kebakaran/' . $item['foto']) ?>" 
                                                 class="img-fluid rounded" 
                                                 alt="Foto Kebakaran">
                                        </div>
                                        <?php endif; ?>
                                        <p><strong>Nama Pelapor:</strong> <?= esc($item['nama_pelapor']) ?></p>
                                        <p><strong>No. Telepon:</strong> <?= esc($item['no_telepon']) ?></p>
                                        <p><strong>Lokasi:</strong> <?= esc($item['lokasi_kebakaran']) ?></p>
                                        <p><strong>Deskripsi:</strong> <?= nl2br(esc($item['deskripsi'])) ?></p>
                                        <p><strong>Status:</strong> <?= $item['status'] ?></p>
                                        <p><strong>Keterangan:</strong> <?= nl2br(esc($item['keterangan'] ?? '-')) ?></p>
                                        <p><strong>Tanggal Laporan:</strong> <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Update Status -->
                        <div class="modal fade" id="updateModal<?= $item['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Status</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form onsubmit="return updateStatus(this)">
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                            <?= csrf_field() ?>
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select class="form-select" name="status" required>
                                                    <option value="Menunggu" <?= $item['status'] == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                                                    <option value="Diproses" <?= $item['status'] == 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                                                    <option value="Selesai" <?= $item['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Keterangan</label>
                                                <textarea class="form-control" name="keterangan" rows="3"><?= esc($item['keterangan'] ?? '') ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function updateStatus(form) {
    const formData = new FormData(form);
    
    fetch('<?= base_url('admin/updateStatus') ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memperbarui status');
    });

    return false;
}
</script>
<?= $this->endSection() ?> 