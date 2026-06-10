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

    <?php
    include 'admin/conf/conf.php';
    $query = "SELECT * FROM hero_section ORDER BY id DESC LIMIT 1";
    $result = $conn->query($query);
    $hero = $result->fetch_assoc();
    ?>

    <main class="main">
        <section id="hero" class="hero">
            <div class="container text-center">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h1 data-aos="fade-up"><?= $hero ? $hero['title'] : 'Welcome to <span>PetNah</span>' ?></h1>
                    <p data-aos="fade-up" data-aos-delay="100">
                        <?= $hero ? $hero['subtitle'] : 'Mudah diakses, cepat, dan tepat untuk masyarakat.<br>Jelajahi informasi wilayah dengan satu klik.<br>' ?>
                    </p>
                    <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                        <a href="<?= $hero ? $hero['btn_start_link'] : '#' ?>" class="btn-get-started">
                            <?= $hero ? $hero['btn_start_text'] : 'Ayo Mulai' ?>
                        </a>
                        <a href="<?= $hero ? $hero['btn_video_link'] : '#' ?>"
                            class="glightbox btn-watch-video d-flex align-items-center">
                            <i class="bi bi-play-circle"></i>
                            <span><?= $hero ? $hero['btn_video_text'] : 'Nonton Video?' ?></span>
                        </a>
                    </div>
                    <img src="admin/<?= $hero ? $hero['image_path'] : 'assets/img/hero-services-img.webp' ?>"
                        class="img-fluid hero-img" alt="" data-aos="zoom-out" data-aos-delay="300">
                </div>
            </div>
        </section>
    </main>


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <?php include 'core/corejs.php'; ?>


</body>

</html>