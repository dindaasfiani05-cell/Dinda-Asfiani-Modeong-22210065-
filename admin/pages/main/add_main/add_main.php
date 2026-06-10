<?php
if ($_GET['q'] === 'add_main' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $btn_start_text = $_POST['btn_start_text'];
    $btn_start_link = $_POST['btn_start_link'];
    $btn_video_text = $_POST['btn_video_text'];
    $btn_video_link = $_POST['btn_video_link'];

    $image_path = '';
    if ($_FILES['image_path']['name']) {
        $target_dir = "uploads/";
        $image_path = $target_dir . time() . "_" . basename($_FILES["image_path"]["name"]);
        move_uploaded_file($_FILES["image_path"]["tmp_name"], $image_path);
    }

    $stmt = $conn->prepare("INSERT INTO hero_section (title, subtitle, btn_start_text, btn_start_link, btn_video_text, btn_video_link, image_path) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $title, $subtitle, $btn_start_text, $btn_start_link, $btn_video_text, $btn_video_link, $image_path);
    $success = $stmt->execute();

    if ($success) {
        echo "<script>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data berhasil ditambahkan.' }).then(() => {
                window.location.href = '?q=main';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Gagal menambahkan data.' }).then(() => {
                window.location.href = '?q=main';
            });
        </script>";
    }
}
