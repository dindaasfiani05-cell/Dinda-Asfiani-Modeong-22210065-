<div class="col-lg-12">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Pengaturan Shapefiles</h5>

            <?php
            $no = 1;
            // Query untuk mengambil data dari tabel shapefiles
            $query = "SELECT id, file_path, uploaded_at, column_name FROM shapefiles";
            $result = $conn->query($query);
            ?>

            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>File Path</th>
                            <th>Uploaded At</th>
                            <th>Display Column</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo htmlspecialchars($row['file_path']); ?></td>
                            <td><?php echo $row['uploaded_at']; ?></td>
                            <td><?php echo htmlspecialchars($row['column_name']); ?></td>
                            <td>
                                <!-- Tombol Aksi (Edit dan Delete) -->
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal<?php echo $row['id']; ?>">Delete</button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1"
                            aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Shapefile</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="?q=edit" method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <div class="mb-3">
                                                <label for="columnName" class="form-label">Display Column</label>
                                                <input type="text" class="form-control" name="columnName"
                                                    value="<?php echo htmlspecialchars($row['column_name']); ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="newShapefile" class="form-label">Upload New Shapefile
                                                    (.zip)</label>
                                                <input type="file" class="form-control" name="newShapefile"
                                                    accept=".zip">
                                                <small class="text-muted">Leave blank if you don't want to replace the
                                                    file.</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Delete -->
                        <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1"
                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus shapefile
                                        <strong><?php echo htmlspecialchars($row['file_path']); ?></strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <a href="?q=delete&id=<?php echo $row['id']; ?>"
                                            class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data shapefiles.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php $conn->close(); ?>
        </div>
    </div>
</div>