<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
        <a href="index" class="logo d-flex align-items-center me-auto">
            <img src="./assets/img/baru1.png" alt="">
            <h1 class="sitename">PetNah</h1>
        </a>
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="index" id="beranda-link">Beranda</a></li>
                <li><a href="peta" id="peta-link">Peta Tanah</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>

<script>
// Dapatkan URL saat ini
const currentURL = window.location.pathname;

// Referensi link menu
const berandaLink = document.getElementById("beranda-link");
const petaLink = document.getElementById("peta-link");

// Cek URL dan tambahkan kelas 'active' ke link yang sesuai
if (currentURL.includes("/index")) {
    berandaLink.classList.add("active");
} else if (currentURL.includes("/peta")) {
    petaLink.classList.add("active");
}
</script>