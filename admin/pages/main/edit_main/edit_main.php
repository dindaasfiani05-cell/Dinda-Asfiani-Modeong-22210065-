<?php
if ($_GET['q'] === 'edit_main' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $btn_start_text = $_POST['btn_start_text'];
    $btn_start_link = $_POST['btn_start_link'];
    $btn_video_text = $_POST['btn_video_text'];
    $btn_video_link = $_POST['btn_video_link'];

    $sql = "UPDATE hero_section SET 
                title = ?, subtitle = ?, 
                btn_start_text = ?, btn_start_link = ?, 
                btn_video_text = ?, btn_video_link = ?";
    $params = [$title, $subtitle, $btn_start_text, $btn_start_link, $btn_video_text, $btn_video_link];
    $types = "ssssss";

    if ($_FILES['image_path']['name']) {
        $target_dir = "uploads/";
        $image_path = $target_dir . time() . "_" . basename($_FILES["image_path"]["name"]);
        move_uploaded_file($_FILES["image_path"]["tmp_name"], $image_path);

        $sql .= ", image_path = ?";
        $params[] = $image_path;
        $types .= "s";
    }

    $sql .= " WHERE id = ?";
    $params[] = $id;
    $types .= "i";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $success = $stmt->execute();

    if ($success) {
        echo "<script>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data berhasil diperbarui.' }).then(() => {
                window.location.href = '?q=main';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Gagal memperbarui data.' }).then(() => {
                window.location.href = '?q=main';
            });
        </script>";
    }
}
