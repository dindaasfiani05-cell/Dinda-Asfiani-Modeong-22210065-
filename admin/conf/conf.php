<?php
$host = "localhost"; // Host database (biasanya localhost)
$user = "root"; // Username database Anda
$password = ""; // Password database Anda
$database = "dinda"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
