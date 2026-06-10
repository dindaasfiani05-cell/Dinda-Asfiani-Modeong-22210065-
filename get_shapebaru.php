<?php
header('Content-Type: application/json');

include 'admin/conf/conf.php';

// Query untuk mendapatkan daftar shapefiles
$query = "SELECT file_path, column_name FROM shapefiles ORDER BY uploaded_at DESC";
$result = $conn->query($query);

$files = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $filePath = "/dindabaru/admin/" . $row['file_path'];

        // Debugging: Periksa apakah file ada di server
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $filePath)) {
            $files[] = [
                'path' => $filePath,
                'column_name' => $row['column_name'] ?? 'REMARK' // Default ke 'REMARK'
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

$conn->close();
