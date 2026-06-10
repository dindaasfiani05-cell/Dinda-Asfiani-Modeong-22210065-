<div class="row g-4">
    <style>
        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>


    <?php

    // Total Akun Pengguna
    $q1 = $conn->query("SELECT COUNT(*) AS total_users FROM users");
    $totalUsers = $q1->fetch_assoc()['total_users'] ?? 0;

    // Total Shapefile Terupload
    $q2 = $conn->query("SELECT COUNT(*) AS total_uploads FROM shp_upload");
    $totalUploads = $q2->fetch_assoc()['total_uploads'] ?? 0;

    // Total GeoJSON yang berhasil diklasifikasi (berisi kategori_klasifikasi)
    $q3 = $conn->query("SELECT COUNT(*) AS classified FROM shp_upload WHERE geojson_path IS NOT NULL AND geojson_path != ''");
    $totalClassified = $q3->fetch_assoc()['classified'] ?? 0;

    // Estimasi user aktif dalam 7 hari terakhir (contoh, bisa disesuaikan)
    $q4 = $conn->query("SELECT COUNT(*) AS recent_users FROM users WHERE created_at >= NOW() - INTERVAL 7 DAY");
    $recentUsers = $q4->fetch_assoc()['recent_users'] ?? 0;
    ?>
    <!-- INFO CARDS -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Pengguna</h6>
                    <h4 class="fw-bold text-dark"><?= $totalUsers ?></h4>
                    <small class="text-muted">Update: <?= date('H:i a') ?></small>
                </div>
                <div class="card-footer border-0" style="height: 5px; background-color: #0d6efd;"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Upload Shapefile</h6>
                    <h4 class="fw-bold text-dark"><?= $totalUploads ?></h4>
                    <small class="text-muted">Update: <?= date('H:i a') ?></small>
                </div>
                <div class="card-footer border-0" style="height: 5px; background-color: #dc3545;"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Data Terklasifikasi</h6>
                    <h4 class="fw-bold text-dark"><?= $totalClassified ?></h4>
                    <small class="text-muted">Update: <?= date('H:i a') ?></small>
                </div>
                <div class="card-footer border-0" style="height: 5px; background-color: #ffc107;"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted mb-2">User Baru Minggu Ini</h6>
                    <h4 class="fw-bold text-dark"><?= $recentUsers ?></h4>
                    <small class="text-muted">Update: <?= date('H:i a') ?></small>
                </div>
                <div class="card-footer border-0" style="height: 5px; background-color: #198754;"></div>
            </div>
        </div>
    </div>



    <!-- VIDEO + CHART -->
    <div class="col-md-8">
        <div class="card shadow-sm h-100">
            <div class="card-body p-3">
                <video class="video" width="100%" controls muted autoplay>
                    <source src="assets/V1.mp4" type="video/mp4">
                    Browser Anda tidak mendukung pemutar video HTML5.
                </video>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title text-center mb-3">Distribusi Lahan</h5>
                <canvas id="lahanChart" height="220"></canvas>
            </div>
        </div>
    </div>

    <!-- USERS TABLE -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Daftar Pengguna</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'conf/conf.php';
                            $no = 1;
                            $sql = "SELECT id, username, password, created_at FROM users";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row["username"]) ?></td>
                                        <td><?= htmlspecialchars($row["password"]) ?></td>
                                        <td><?= $row["created_at"] ?></td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data pengguna.</td>
                                </tr>
                            <?php
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- STYLE -->
<style>
    .video {
        border-radius: 10px;
    }

    .card-title {
        font-weight: bold;
    }

    .card h4 {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .card small {
        font-size: 0.8rem;
    }

    .card {
        border-radius: 10px;
    }
</style>

<script>
    const ctx = document.getElementById('lahanChart').getContext('2d');
    const lahanChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Lahan Produktif', 'Tidak Produktif', 'Area Terbangun', 'Vegetasi Liar'],
            datasets: [{
                data: [25, 40, 20, 15],
                backgroundColor: [
                    'rgba(0, 123, 255, 0.7)',
                    'rgba(220, 53, 69, 0.7)',
                    'rgba(255, 193, 7, 0.7)',
                    'rgba(40, 167, 69, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>