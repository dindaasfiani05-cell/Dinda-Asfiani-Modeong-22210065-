<?php
include 'admin/conf/conf.php';

$result = $conn->query("SELECT geojson_path FROM shp_upload WHERE geojson_path IS NOT NULL ORDER BY uploaded_at DESC");

$paths = [];
while ($row = $result->fetch_assoc()) {
    $paths[] = 'admin/' . ltrim($row['geojson_path'], '/');
}

echo json_encode($paths);
