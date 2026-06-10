<?php
if ($_GET['q'] === 'up_file' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'] ?? '';
    $file = $_FILES['shapefile_zip'] ?? null;

    if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Upload Gagal!', text: 'File tidak ditemukan atau terjadi error.' });
        </script>";
        exit;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($ext !== 'zip') {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Format Tidak Valid', text: 'File harus berekstensi .zip' }).then(() => {
                history.back();
            });
        </script>";
        exit;
    }

    $upload_dir = "uploads/shapefiles/";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $file_name = time() . "_" . basename($file['name']);
    $target_path = $upload_dir . $file_name;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        // Simpan metadata ke DB
        $stmt = $conn->prepare("INSERT INTO shp_upload (judul, file_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $judul, $file_name);
        $stmt->execute();
        $id_upload = $conn->insert_id;

        $extract_dir = $upload_dir . pathinfo($file_name, PATHINFO_FILENAME);
        if (!is_dir($extract_dir)) mkdir($extract_dir, 0777, true);

        $zip = new ZipArchive;
        if ($zip->open($target_path) === TRUE) {
            $zip->extractTo($extract_dir);
            $zip->close();
        } else {
            echo "<script>
                Swal.fire({ icon: 'error', title: 'Gagal Ekstrak ZIP', text: 'File ZIP tidak bisa diekstrak.' }).then(() => {
                    history.back();
                });
            </script>";
            exit;
        }

        // Cari file SHP
        $shp_file = '';
        foreach (scandir($extract_dir) as $f) {
            if (strtolower(pathinfo($f, PATHINFO_EXTENSION)) === 'shp') {
                $shp_file = $extract_dir . '/' . $f;
                break;
            }
        }

        if ($shp_file && file_exists($shp_file)) {
            $geojson_file = $extract_dir . '/result.geojson';

            // PATH OGR2OGR QGIS
            // Sesuaikan nama folder QGIS jika berbeda
            $ogr2ogr = 'C:\\Program Files\\QGIS 3.44.10\\bin\\ogr2ogr.exe';

            if (!file_exists($ogr2ogr)) {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'OGR2OGR Tidak Ditemukan',
                        text: 'File ogr2ogr.exe tidak ditemukan di C:\\\\Program Files\\\\QGIS 3.44.10\\\\bin\\\\ogr2ogr.exe'
                    }).then(() => {
                        history.back();
                    });
                </script>";
                exit;
            }

            // Command konversi SHP ke GeoJSON
            $cmd = '"' . $ogr2ogr . '" -f GeoJSON '
                . '"' . $geojson_file . '" '
                . '"' . $shp_file . '" '
                . '-t_srs EPSG:4326 2>&1';

            exec($cmd, $output, $return_code);

            if ($return_code === 0 && file_exists($geojson_file)) {
                // Simpan path geojson
                $stmt = $conn->prepare("UPDATE shp_upload SET geojson_path = ? WHERE id = ?");
                $stmt->bind_param("si", $geojson_file, $id_upload);
                $stmt->execute();

                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Upload Berhasil',
                        text: 'File berhasil diupload dan dikonversi ke GeoJSON.',
                        showDenyButton: true,
                        confirmButtonText: 'Jalankan Klasifikasi',
                        denyButtonText: 'Lihat Upload'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '?q=run_rule_based&id=$id_upload';
                        } else {
                            window.location.href = '?q=upload';
                        }
                    });
                </script>";
            } else {
                $error_message = implode("\\n", $output);
                $error_message = addslashes($error_message);

                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Konversi Gagal',
                        html: '<pre style=\"text-align:left;white-space:pre-wrap;\">$error_message</pre>'
                    }).then(() => {
                        history.back();
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({ icon: 'error', title: 'File SHP Tidak Ditemukan', text: 'Pastikan file ZIP mengandung .shp' }).then(() => {
                    history.back();
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Gagal Upload', text: 'Terjadi kesalahan saat mengunggah file.' }).then(() => {
                history.back();
            });
        </script>";
    }
}