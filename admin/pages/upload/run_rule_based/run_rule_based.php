<?php
if ($_GET['q'] === 'run_rule_based' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $result = $conn->query("SELECT geojson_path FROM shp_upload WHERE id = $id");
    $row = $result->fetch_assoc();
    $geojson_path = $row['geojson_path'];

    if (!file_exists($geojson_path)) {
        echo "<script>alert('File GeoJSON tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    $json = file_get_contents($geojson_path);
    $data = json_decode($json, true);

    if (!isset($data['features'])) {
        echo "<script>alert('Format GeoJSON tidak valid.'); window.history.back();</script>";
        exit;
    }

    // Fungsi klasifikasi berbasis REMARK
    function classifyRemark($remark)
    {
        $remark = strtolower(trim($remark));

        if ($remark === 'sawah') return 'Lahan Produktif';
        if ($remark === 'perkebunan/kebun') return 'Lahan Produktif';
        if ($remark === 'tegalan/ladang') return 'Lahan Semi Produktif';
        if ($remark === 'empang') return 'Lahan Perairan Buatan';
        if ($remark === 'tanah kosong/gundul') return 'Tidak Produktif';
        if ($remark === 'semak belukar') return 'Vegetasi Liar';
        if ($remark === 'pemukiman dan tempat kegiatan') return 'Area Terbangun';
        if (strpos($remark, 'pendidikan') !== false) return 'Fasilitas Pendidikan';
        if ($remark === 'hutan rimba') return 'Hutan Alami';
        if ($remark === 'sungai' || $remark === 'danau/situ') return 'Perairan Alami';

        return 'Lainnya';
    }

    // Proses klasifikasi ke setiap fitur
    foreach ($data['features'] as &$feature) {
        $remark = $feature['properties']['REMARK'] ?? '';
        $rpbulat = $feature['properties']['RPBULAT'] ?? '';
        $kelurahan = $feature['properties']['KELURAHAN'] ?? '';
        $kecamatan = $feature['properties']['KECAMATAN'] ?? '';

        $classification = classifyRemark($remark);

        $feature['properties']['REMARK'] = $remark;
        $feature['properties']['RPBULAT'] = $rpbulat;
        $feature['properties']['KELURAHAN'] = $kelurahan;
        $feature['properties']['KECAMATAN'] = $kecamatan;
        $feature['properties']['kategori_klasifikasi'] = $classification;
    }

    file_put_contents($geojson_path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Klasifikasi Berhasil!',
            text: 'Klasifikasi berbasis aturan berhasil diterapkan dan disimpan.',
            confirmButtonText: 'Lihat Data'
        }).then(() => {
            window.location.href = '?q=upload';
        });
    </script>";
}