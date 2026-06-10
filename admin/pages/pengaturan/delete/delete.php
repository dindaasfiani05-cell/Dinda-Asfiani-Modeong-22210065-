<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Menghindari SQL Injection

    // Ambil informasi file sebelum menghapus
    $query = "SELECT file_path FROM shapefiles WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_path = $row['file_path'];

        // Hapus file dari sistem jika ada
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Hapus data dari database
        $deleteQuery = "DELETE FROM shapefiles WHERE id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Shapefile berhasil dihapus!');
                    window.location.href = '?q=pengaturan';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal menghapus shapefile.');
                    window.location.href = '?q=pengaturan';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Data tidak ditemukan.');
                window.location.href = '?q=pengaturan';
              </script>";
    }

    $stmt->close();
} else {
    echo "<script>
            alert('ID tidak valid.');
            window.location.href = '?q=pengaturan';
          </script>";
}

$conn->close();