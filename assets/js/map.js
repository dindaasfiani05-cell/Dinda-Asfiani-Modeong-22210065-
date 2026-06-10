// // Inisialisasi peta dan atur tampilan awal
// const map = L.map("map").setView([1.3127, 124.8189], 13);

// // Tambahkan layer OpenStreetMap
// L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
//   attribution:
//     '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
// }).addTo(map);

// // Fungsi untuk menghasilkan warna acak
// function getRandomColor() {
//   const letters = "0123456789ABCDEF";
//   let color = "#";
//   for (let i = 0; i < 6; i++) {
//     color += letters[Math.floor(Math.random() * 16)];
//   }
//   return color;
// }

// // Fungsi untuk mengatur style setiap poligon
// function getStyle(feature) {
//   return {
//     color: "#000000",
//     weight: 2,
//     opacity: 0.8,
//     fillColor: getRandomColor(),
//     fillOpacity: 0.5,
//   };
// }

// // Array untuk menyimpan semua layer groups dari shapefiles yang ditambahkan
// let allLayerGroups = [];

// // Fungsi untuk menambahkan animasi fade-in ke layer
// function fadeIn(layer) {
//   const el = layer.getElement();
//   if (el) {
//     el.style.opacity = 0;
//     el.style.transition = "opacity 0.5s ease-in-out";
//     requestAnimationFrame(() => (el.style.opacity = 1));
//   }
// }

// // Fungsi untuk menambahkan animasi fade-out sebelum menghapus layer
// function fadeOut(layer, callback) {
//   const el = layer.getElement();
//   if (el) {
//     el.style.transition = "opacity 0.5s ease-in-out";
//     el.style.opacity = 0;
//     setTimeout(() => {
//       if (callback) callback();
//     }, 500);
//   } else if (callback) {
//     callback();
//   }
// }

// // Memuat semua shapefiles dari get_shape.php
// fetch("./get_shape.php")
//   .then((response) => response.json())
//   .then((data) => {
//     if (data.file_paths) {
//       data.file_paths.forEach((fileData) => {
//         const filePath = fileData.path;
//         const displayColumn = fileData.column_name; // Kolom spesifik untuk digunakan

//         fetch(filePath)
//           .then((response) => response.arrayBuffer())
//           .then((buffer) => {
//             shp(buffer)
//               .then((geojson) => {
//                 const layerGroup = L.layerGroup();

//                 L.geoJSON(geojson, {
//                   style: getStyle,
//                   onEachFeature: function (feature, layer) {
//                     // DEBUG: Tampilkan semua properti dari setiap fitur di shapefile ini
//                     console.log("Properti dari fitur:", feature.properties);

//                     const valueToDisplay =
//                       feature.properties[displayColumn] || "Tidak Diketahui";
//                     layer.bindPopup(`<b>${valueToDisplay}</b>`);
//                     layerGroup.addLayer(layer);
//                   },
//                 });

//                 layerGroup.addTo(map);
//                 allLayerGroups.push(layerGroup);
//               })
//               .catch((error) =>
//                 console.error("Error parsing shapefile:", error)
//               );
//           })
//           .catch((error) => console.error("Error loading ZIP file:", error));
//       });
//     } else {
//       console.error("No shapefile found in the database.");
//     }
//   })
//   .catch((error) => console.error("Error fetching shapefile paths:", error));

// // Fungsi untuk menerapkan filter berdasarkan nilai "REMARK"
// function applyFilter() {
//   const checkboxes = document.querySelectorAll(
//     "#filter-controls .form-check-input"
//   );
//   const selectedValues = Array.from(checkboxes)
//     .filter((checkbox) => checkbox.checked && checkbox.value !== "all")
//     .map((checkbox) => checkbox.value);

//   allLayerGroups.forEach((layerGroup) => {
//     layerGroup.eachLayer((layer) => {
//       const remark = layer.feature.properties?.REMARK || "";
//       if (selectedValues.length === 0 || selectedValues.includes(remark)) {
//         if (!map.hasLayer(layer)) {
//           fadeIn(layer);
//           layer.addTo(map);
//         }
//       } else {
//         if (map.hasLayer(layer)) {
//           fadeOut(layer, () => map.removeLayer(layer));
//         }
//       }
//     });
//   });
// }
