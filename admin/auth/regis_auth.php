<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Proses</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php
    // Koneksi ke database
    include '../conf/conf.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Mengambil data dari form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah username sudah ada di database
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Username sudah ada
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Username sudah terdaftar, coba username lain!'
            }).then(function() {
                window.location = '../register'; // Redirect ke halaman register
            });
        </script>";
        } else {
            // Insert data ke database
            $query = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $username, $hashedPassword);
            $success = $stmt->execute();

            if ($success) {
                // Jika berhasil
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Registrasi Berhasil!',
                    text: 'Anda berhasil mendaftar. Silakan login.'
                }).then(function() {
                    window.location = '../dashboard'; // Redirect ke halaman login
                });
            </script>";
            } else {
                // Jika gagal
                echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Registrasi Gagal!',
                    text: 'Terjadi kesalahan, silakan coba lagi.'
                }).then(function() {
                    window.location = '../register'; // Redirect ke halaman register
                });
            </script>";
            }
        }
        $stmt->close();
        $conn->close();
    }
    ?>

</body>

</html>