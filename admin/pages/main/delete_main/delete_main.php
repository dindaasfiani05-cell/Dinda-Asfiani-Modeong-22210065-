<?php
if ($_GET['q'] === 'delete_main' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM hero_section WHERE id = ?");
    $stmt->bind_param("i", $id);
    $success = $stmt->execute();

    if ($success) {
        echo "<script>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data berhasil dihapus.' }).then(() => {
                window.location.href = '?q=main';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Gagal menghapus data.' }).then(() => {
                window.location.href = '?q=main';
            });
        </script>";
    }
}
