<?php

$id = $_POST['id'];
$columnName = $_POST['columnName'];
$success = false;

// Jika file baru diunggah, proses penggantian file
if (!empty($_FILES['newShapefile']['name'])) {
    $targetDir = "uploads/shapefiles/";
    $newFileName = basename($_FILES['newShapefile']['name']);
    $targetFilePath = $targetDir . $newFileName;

    // Hapus file lama jika ada
    $query = "SELECT file_path FROM shapefiles WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if (file_exists($row['file_path'])) {
        unlink($row['file_path']);
    }

    // Pindahkan file baru
    if (move_uploaded_file($_FILES['newShapefile']['tmp_name'], $targetFilePath)) {
        // Update file path dan kolom display
        $query = "UPDATE shapefiles SET file_path = ?, column_name = ?, uploaded_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $targetFilePath, $columnName, $id);
        $success = $stmt->execute();
    }
} else {
    // Update hanya kolom display
    $query = "UPDATE shapefiles SET column_name = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $columnName, $id);
    $success = $stmt->execute();
}

$stmt->close();
$conn->close();

if ($success) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Shapefile berhasil diperbarui.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '?q=pengaturan';
        });
    </script>";
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat memperbarui shapefile.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '?q=pengaturan';
        });
    </script>";
}