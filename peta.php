<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Dinda</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <?php include 'core/corecss.php'; ?>
</head>

<body class="index-page">

    <?php include 'core/header.php'; ?>

    <main class="main">

        <section id="about" class="about section mt-5">
            <div class="container">
                <h1 class="mt-3 text-center" data-aos="fade-up">Welcome to <span class="aboutpetnah">PetNah</span></h1>
                <p class="text-center mb-5" data-aos="fade-up" data-aos-delay="100">Mudah diakses, cepat, dan tepat
                    untuk
                    masyarakat.
                    Jelajahi informasi wilayah dengan satu klik.<br></p>
                <div class="row gy-4">
                    <!-- Filter Controls -->
                    <div class="col-lg-4 content" data-aos="fade-up" data-aos-delay="100">
                        <div id="filter-controls" class="mb-4">
                            <label class="form-label fw-bold">Filter berdasarkan REMARK:</label>
                            <div class="row row-cols-1 row-cols-md-2 g-2">
                                <div class="col">
                                    <div class="form-check"><input class="form-check-input" type="checkbox" value="all"
                                            id="filterAll" onchange="applyFilter()" checked><label
                                            class="form-check-label" for="filterAll">Semua</label></div>
                                </div>
                                <div class="col">
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            value="Empang" id="filterEmpang" onchange="applyFilter()"><label
                                            class="form-check-label" for="filterEmpang">Empang</label></div>
                                </div>
                                <div class="col">
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            value="Sawah" id="filterSawah" onchange="applyFilter()"><label
                                            class="form-check-label" for="filterSawah">Sawah</label></div>
                                </div>
                                <div class="col">
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            value="Tegalan/Ladang" id="filterTegalan" onchange="applyFilter()"><label
                                            class="form-check-label" for="filterTegalan">Tegalan/Ladang</label></div>
                                </div>
                                <div class="col">
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            value="Perkebunan/Kebun" id="filterPerkebunan"
                                            onchange="applyFilter()"><label class="form-check-label"
                                            for="filterPerkebunan">Perkebunan/Kebun</label></div>
                                </div>
                                <div class="col">
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            value="Semak Belukar" id="filterSemak" onchange="applyFilter()"><label
                                            class="form-check-label" for="filterSemak">Semak Belukar</label></div>
                                </div>
                                <div class="col">
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            value="Tanah Kosong/Gundul" id="filterTanahKosong"
                                            onchange="applyFilter()"><label class="form-check-label"
                                            for="filterTanahKosong">Tanah Kosong/Gundul</label></div>
                                </div>
                                <div class="col">
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            value="Permukiman dan Tempat Kegiatan" id="filterPermukiman"
                                            onchange="applyFilter()"><label class="form-check-label"
                                            for="filterPermukiman">Permukiman dan Tempat Kegiatan</label></div>
                                </div>
                                <div class="col">
                                    <div class="form-check"><input class="form-check-input" type="checkbox"
                                            value="Hutan Rimba" id="filterHutan" onchange="applyFilter()"><label
                                            class="form-check-label" for="filterHutan">Hutan Rimba</label></div>
                                </div>
                            </div>
                            <hr>

                            <label class="form-label fw-bold">Filter berdasarkan Kota/Kabupaten:</label>
                            <select id="filterKelurahan" class="form-select mb-3" onchange="applyFilter()">
                                <option value="all">Semua Kota/Kabupaten</option>
                            </select>

                            <label class="form-label fw-bold">Filter berdasarkan Kecamatan:</label>
                            <select id="filterKecamatan" class="form-select mb-3" onchange="applyFilter()">
                                <option value="all">Semua Kecamatan</option>
                            </select>

                            <!-- <label class="form-label fw-bold">Filter berdasarkan RPBULAT:</label>
                            <input type="text" id="filterRPBULAT" class="form-control mb-3"
                                placeholder="Cari nilai RPBULAT..." onkeyup="applyFilter()"> -->

                            <div class="card mt-2">
                                <div class="card-header">Petunjuk Penggunaan</div>
                                <div class="card-body">
                                    <blockquote class="blockquote mb-0">
                                        <p>Gunakan <span class="text-danger">checkbox</span> di atas untuk memfilter
                                            area berdasarkan kategori. Pastikan untuk <span
                                                class="text-danger">zoom-in</span> terlebih dahulu Petanya.</p>
                                        <footer class="blockquote-footer mt-2">Navigasi lebih mudah dengan menggunakan
                                            Laptop/PC di <cite title="Map">Map</cite></footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map Container -->
                    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                        <div id="cesiumContainer" class="border rounded" style="height: 500px; width: 100%;"></div>
                    </div>

                </div>
            </div>
        </section>

    </main>


    <?php include 'core/footer.php'; ?>


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <?php include 'core/corejs.php'; ?>

    <script>
    Cesium.Ion.defaultAccessToken =
        "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiIzMWMzMDA1Yy03OGI1LTQ3MmMtYjk1My1lZGMyYmZkYjU4ZjIiLCJpZCI6Mjg0NDY2LCJpYXQiOjE3NDIwMDc2MTF9.CElwNoBrlFjkDXpD3fzzGXFhKaBpuFiZmU5kb1DS4VY";

    var viewer = new Cesium.Viewer("cesiumContainer", {
        terrainProvider: new Cesium.EllipsoidTerrainProvider(),
        timeline: false,
        animation: false,
        baseLayerPicker: false,
        selectionIndicator: true,
        infoBox: true,
    });

    const center = Cesium.Cartesian3.fromDegrees(124.8189, 1.3127, 5000);
    viewer.camera.flyTo({
        destination: center
    });

    // Warna berdasarkan kategori REMARK
    const remarkColorMap = {
        "Empang": Cesium.Color.CYAN.withAlpha(0.6),
        "Sawah": Cesium.Color.GREEN.withAlpha(0.6),
        "Tegalan/Ladang": Cesium.Color.BURLYWOOD.withAlpha(0.6),
        "Perkebunan/Kebun": Cesium.Color.FORESTGREEN.withAlpha(0.6),
        "Semak Belukar": Cesium.Color.DARKOLIVEGREEN.withAlpha(0.6),
        "Tanah Kosong/Gundul": Cesium.Color.GRAY.withAlpha(0.6),
        "Permukiman dan Tempat Kegiatan": Cesium.Color.ORANGE.withAlpha(0.6),
        "Pemukiman dan Tempat Kegiatan": Cesium.Color.ORANGE.withAlpha(0.6),
        "Hutan Rimba": Cesium.Color.DARKGREEN.withAlpha(0.6)
    };

    let allEntities = [];
    let kelurahanSet = new Set();
    let kecamatanSet = new Set();

    fetch('get_classified_geojson.php')
        .then(response => response.json())
        .then(paths => {
            return Promise.all(paths.map(path =>
                Cesium.GeoJsonDataSource.load(path, {
                    clampToGround: true
                }).then(dataSource => {
                    viewer.dataSources.add(dataSource);
                    viewer.flyTo(dataSource);

                    const entities = dataSource.entities.values;

                    for (let i = 0; i < entities.length; i++) {
                        let entity = entities[i];
                        let props = entity.properties;

                        console.log(props?.propertyNames);

                        let remark = props?.REMARK?._value || "";

                        // Mapping dari GeoJSON kamu:
                        // WADMKK = Kota/Kabupaten
                        // WADMKC = Kecamatan
                        // WADMPR = Provinsi
                        let kelurahan = props?.WADMKK?._value || "";
                        let kecamatan = props?.WADMKC?._value || "";
                        let provinsi = props?.WADMPR?._value || "";

                        let rpbulat = props?.RPBULAT?._value || "";

                        if (kelurahan) {
                            kelurahanSet.add(kelurahan);
                        }

                        if (kecamatan) {
                            kecamatanSet.add(kecamatan);
                        }

                        let fillColor = remarkColorMap[remark] || Cesium.Color.LIGHTGRAY.withAlpha(0.5);

                        if (Cesium.defined(entity.polygon)) {
                            entity.polygon.material = fillColor;
                            entity.polygon.outline = true;
                            entity.polygon.outlineColor = Cesium.Color.BLACK;
                            entity.polygon.outlineWidth = 1.0;
                        }

                        let html = `<strong>Detail Zona:</strong><br>`;
                        html += `<b>REMARK</b>: ${remark}<br>`;
                        html += `<b>Kota/Kabupaten</b>: ${kelurahan}<br>`;
                        html += `<b>Kecamatan</b>: ${kecamatan}<br>`;
                        html += `<b>Provinsi</b>: ${provinsi}<br>`;
                        html += `<b>RPBULAT</b>: ${rpbulat}<br>`;

                        if (props?.kategori_klasifikasi?._value) {
                            html +=
                                `<b>Kategori Klasifikasi</b>: ${props.kategori_klasifikasi._value}<br>`;
                        }

                        entity.description = html;

                        allEntities.push(entity);
                    }

                    // Isi dropdown Kota/Kabupaten dan Kecamatan
                    populateSelect('filterKelurahan', kelurahanSet);
                    populateSelect('filterKecamatan', kecamatanSet);

                    applyFilter();
                })
            ));
        })
        .catch(err => {
            console.error("Gagal mengambil atau memproses GeoJSON:", err);
        });

    function populateSelect(selectId, dataSet) {
        const select = document.getElementById(selectId);

        if (!select) return;

        // Hapus option lama, sisakan option pertama "Semua..."
        while (select.options.length > 1) {
            select.remove(1);
        }

        Array.from(dataSet).sort().forEach(value => {
            const option = document.createElement('option');
            option.value = value;
            option.textContent = value;
            select.appendChild(option);
        });
    }

    function applyFilter() {
        const checkedValues = Array.from(
            document.querySelectorAll('#filter-controls input.form-check-input:checked')
        ).map(cb => cb.value);

        const selectedKelurahan = document.getElementById('filterKelurahan')?.value || 'all';
        const selectedKecamatan = document.getElementById('filterKecamatan')?.value || 'all';
        const searchRPBULAT = document.getElementById('filterRPBULAT')?.value.toLowerCase() || '';

        allEntities.forEach(entity => {
            const remark = entity.properties?.REMARK?._value ?? '';

            // Ini yang tadi masih salah.
            // Jangan pakai KELURAHAN dan KECAMATAN karena di GeoJSON kamu kosong.
            const kelurahan = entity.properties?.WADMKK?._value ?? '';
            const kecamatan = entity.properties?.WADMKC?._value ?? '';

            const rpbulat = String(entity.properties?.RPBULAT?._value ?? '').toLowerCase();

            const matchRemark =
                checkedValues.includes('all') || checkedValues.includes(remark);

            const matchKelurahan =
                selectedKelurahan === 'all' || kelurahan === selectedKelurahan;

            const matchKecamatan =
                selectedKecamatan === 'all' || kecamatan === selectedKecamatan;

            const matchRPBULAT =
                searchRPBULAT === '' || rpbulat.includes(searchRPBULAT);

            entity.show = matchRemark && matchKelurahan && matchKecamatan && matchRPBULAT;
        });
    }
    </script>

</body>

</html>