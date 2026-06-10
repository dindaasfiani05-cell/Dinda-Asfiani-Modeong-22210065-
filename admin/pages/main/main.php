<div class="col-lg-12">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Pengaturan Hero Section</h5>

            <!-- Tombol Tambah -->
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-circle"></i> Tambah Data
            </button>

            <?php
            $no = 1;
            $query = "SELECT * FROM hero_section ORDER BY id DESC";
            $result = $conn->query($query);
            ?>

            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Subjudul</th>
                            <th>Tombol Mulai</th>
                            <th>Link Mulai</th>
                            <th>Video Teks</th>
                            <th>Video Link</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['title']) ?></td>
                                    <td><?= htmlspecialchars($row['subtitle']) ?></td>
                                    <td><?= htmlspecialchars($row['btn_start_text']) ?></td>
                                    <td><?= htmlspecialchars($row['btn_start_link']) ?></td>
                                    <td><?= htmlspecialchars($row['btn_video_text']) ?></td>
                                    <td><?= htmlspecialchars($row['btn_video_link']) ?></td>
                                    <td><img src="<?= $row['image_path'] ?>" width="100" alt="Hero Image"></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal<?= $row['id'] ?>">Hapus</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">Belum ada data hero section.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php mysqli_data_seek($result, 0); ?>

            <!-- Modal Edit dan Delete (DILUAR TABLE) -->
            <?php while ($row = $result->fetch_assoc()): ?>
                <!-- Modal Edit -->
                <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="?q=edit_main" method="post" enctype="multipart/form-data"
                            class="modal-content bg-white shadow">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Hero Section</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <div class="mb-2">
                                    <label>Judul</label>
                                    <input type="text" name="title" class="form-control"
                                        value="<?= htmlspecialchars($row['title']) ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label>Subjudul</label>
                                    <textarea name="subtitle" class="form-control"
                                        required><?= htmlspecialchars($row['subtitle']) ?></textarea>
                                </div>
                                <div class="mb-2">
                                    <label>Teks Tombol Mulai</label>
                                    <input type="text" name="btn_start_text" class="form-control"
                                        value="<?= $row['btn_start_text'] ?>">
                                </div>
                                <div class="mb-2">
                                    <label>Link Tombol Mulai</label>
                                    <input type="text" name="btn_start_link" class="form-control"
                                        value="<?= $row['btn_start_link'] ?>">
                                </div>
                                <div class="mb-2">
                                    <label>Teks Video</label>
                                    <input type="text" name="btn_video_text" class="form-control"
                                        value="<?= $row['btn_video_text'] ?>">
                                </div>
                                <div class="mb-2">
                                    <label>Link Video</label>
                                    <input type="text" name="btn_video_link" class="form-control"
                                        value="<?= $row['btn_video_link'] ?>">
                                </div>
                                <div class="mb-2">
                                    <label>Ganti Gambar</label>
                                    <input type="file" name="image_path" class="form-control">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Delete -->
                <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="?q=delete_main" method="post" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Hapus Hero Section</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                Apakah Anda yakin ingin menghapus data ini?
                            </div>
                            <div class="modal-footer">
                                <!-- ✅ Gunakan type="button" untuk batal -->
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </div>
                        </form>

                    </div>
                </div>
            <?php endwhile; ?>

            <?php $conn->close(); ?>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="?q=add_main" method="post" enctype="multipart/form-data" class="modal-content bg-white shadow">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Hero Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label>Judul</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Subjudul</label>
                    <textarea name="subtitle" class="form-control" required></textarea>
                </div>
                <div class="mb-2">
                    <label>Teks Tombol Mulai</label>
                    <input type="text" name="btn_start_text" class="form-control">
                </div>
                <div class="mb-2">
                    <label>Link Tombol Mulai</label>
                    <input type="text" name="btn_start_link" class="form-control">
                </div>
                <div class="mb-2">
                    <label>Teks Video</label>
                    <input type="text" name="btn_video_text" class="form-control">
                </div>
                <div class="mb-2">
                    <label>Link Video</label>
                    <input type="text" name="btn_video_link" class="form-control">
                </div>
                <div class="mb-2">
                    <label>Upload Gambar</label>
                    <input type="file" name="image_path" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>
</div>