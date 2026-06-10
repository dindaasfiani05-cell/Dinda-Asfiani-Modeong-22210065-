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
    session_start();
    include '../conf/conf.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Set session untuk menandakan bahwa user telah login
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_logged_in'] = true; // Tambahkan sesi login

                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil!',
                    text: 'Selamat datang, $username.'
                }).then(function() {
                    window.location = '../'; // Redirect ke dashboard
                });
            </script>";
            } else {
                echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal!',
                    text: 'Password salah, coba lagi.'
                }).then(function() {
                    window.location = '../index'; // Redirect kembali ke halaman login
                });
            </script>";
            }
        } else {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal!',
                text: 'Username tidak ditemukan.'
            }).then(function() {
                window.location = '../index'; // Redirect kembali ke halaman login
            });
        </script>";
        }
        $stmt->close();
        $conn->close();
    }
    ?>


</body>

</html>