<?php
header('Content-Type: application/json');

include 'admin/conf/conf.php';

// Query untuk mendapatkan path file shapefiles dan nama kolom yang ingin ditampilkan
$query = "SELECT file_path, column_name FROM shapefiles ORDER BY uploaded_at DESC";
$result = $conn->query($query);

$files = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $filePath = "/dindabaru/admin/" . $row['file_path'];

        // Cek apakah file ada di server
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $filePath)) {
            $files[] = [
                'path' => $filePath,
                'column_name' => $row['column_name'] ?? 'REMARK' // Default ke 'REMARK' jika kolom kosong
            ];
        }
    }

    if (!empty($files)) {
        echo json_encode(['file_paths' => $files]);
    } else {
        echo json_encode(['error' => 'No shapefile found on server']);
    }
} else {
    echo json_encode(['error' => 'No shapefile found']);
}

// Tutup koneksi database
$conn->close();
