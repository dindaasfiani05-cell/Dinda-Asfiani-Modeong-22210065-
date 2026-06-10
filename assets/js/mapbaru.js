// document.addEventListener("DOMContentLoaded", function () {
//   // Tetapkan API Key dari Cesium (GANTI dengan token yang kamu buat)
//   Cesium.Ion.defaultAccessToken =
//     "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiIzMWMzMDA1Yy03OGI1LTQ3MmMtYjk1My1lZGMyYmZkYjU4ZjIiLCJpZCI6Mjg0NDY2LCJpYXQiOjE3NDIwMDc2MTF9.CElwNoBrlFjkDXpD3fzzGXFhKaBpuFiZmU5kb1DS4VY";

//   // Inisialisasi Viewer Cesium
//   var viewer = new Cesium.Viewer("cesiumContainer", {
//     terrainProvider: Cesium.createWorldTerrain({
//       requestVertexNormals: true,
//       requestWaterMask: true,
//     }),
//   });

//   // Atur tampilan awal peta ke lokasi yang diinginkan
//   viewer.camera.setView({
//     destination: Cesium.Cartesian3.fromDegrees(124.8189, 1.3127, 2000),
//   });

//   let allEntities = []; // Menyimpan semua entitas shapefile

//   // Ambil daftar shapefiles dari get_shapebaru.php
//   fetch("./get_shapebaru.php")
//     .then((response) => response.json())
//     .then((data) => {
//       if (data.file_paths) {
//         data.file_paths.forEach((fileData) => {
//           const filePath = fileData.path;
//           const displayColumn = fileData.column_name || "REMARK"; // Default ke REMARK jika kosong

//           fetch(filePath)
//             .then((response) => response.arrayBuffer())
//             .then((buffer) => {
//               shp(buffer)
//                 .then((geojson) => {
//                   console.log("Loaded Shapefile:", geojson); // DEBUGGING

//                   geojson.features.forEach((feature) => {
//                     const coordinates = feature.geometry.coordinates[0].map(
//                       (coord) => ({
//                         longitude: coord[0],
//                         latitude: coord[1],
//                         height: 100, // Ketinggian default
//                       })
//                     );

//                     const entity = viewer.entities.add({
//                       polygon: {
//                         hierarchy: Cesium.Cartesian3.fromDegreesArrayHeights(
//                           coordinates.flatMap((coord) => [
//                             coord.longitude,
//                             coord.latitude,
//                             coord.height,
//                           ])
//                         ),
//                         material: Cesium.Color.fromRandom({ alpha: 0.6 }), // Warna acak transparan
//                         outline: true,
//                         outlineColor: Cesium.Color.BLACK,
//                       },
//                       properties: feature.properties,
//                       name:
//                         feature.properties[displayColumn] || "Tidak Diketahui",
//                     });

//                     allEntities.push(entity);
//                   });
//                 })
//                 .catch((error) =>
//                   console.error("Error parsing shapefile:", error)
//                 );
//             })
//             .catch((error) => console.error("Error loading ZIP file:", error));
//         });
//       } else {
//         console.error("No shapefile found in the database.");
//       }
//     })
//     .catch((error) => console.error("Error fetching shapefile paths:", error));

//   // Fungsi untuk menerapkan filter berdasarkan REMARK
//   window.applyFilter = function () {
//     const checkboxes = document.querySelectorAll(
//       "#filter-controls .form-check-input"
//     );
//     const selectedValues = Array.from(checkboxes)
//       .filter((checkbox) => checkbox.checked && checkbox.value !== "all")
//       .map((checkbox) => checkbox.value);

//     allEntities.forEach((entity) => {
//       const remark =
//         entity.properties?.REMARK?.getValue(Cesium.JulianDate.now()) || "";
//       entity.show =
//         selectedValues.length === 0 || selectedValues.includes(remark);
//     });
//   };
// });
