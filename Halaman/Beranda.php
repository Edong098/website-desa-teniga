<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../database/dbConnect.php";

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Teniga</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/CSS/beranda.css">
</head>

<body class="bg-gray-50">

    <!-- HEADER + NAVBAR -->
    <header class="hero-background position-relative">
        <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>

        <!-- Navbar -->
        <div class="container position-relative py-3" style="z-index: 20;">

            <!-- Baris Logo-->
            <div class="d-flex justify-content-start align-items-center w-100 position-relative"
                style="margin-left: 11.5%; transform: translateY(8px);">
                <a href="#home" class="d-flex align-items-center text-white text-decoration-none">
                    <img src="../assets/img/CDR_LOGO_DESA.png"
                        alt="Logo Desa Teniga"
                        style="height:44px; width:auto;">
                    <div class="d-flex flex-column ms-1">
                        <span class="fs-6 fw-bold">DESA TENIGA</span>
                        <span class="small fw-bold">TANJUNG LOMBOK UTARA</span>
                    </div>
                </a>

                <!-- Tombol Mobile -->
                <button id="mobile-menu-btn" class="d-lg-none text-white border-0 bg-transparent ms-3" aria-label="Toggle menu">
                    <i data-lucide="menu" style="width:28px;height:28px"></i>
                </button>
            </div>

            <!-- Baris Navigasi -->
            <nav id="main-navigation" class="d-none d-lg-flex justify-content-center text-white small fw-bold mt-3">
                <a href="../Halaman/Beranda.php" class="nav-link active text-white text-decoration-none px-3"><span class="nav-text">BERANDA</span></a>
                <a href="../Halaman/berita.php" class="nav-link text-white text-decoration-none px-3"><span class="nav-text">KABAR DESA</span></a>
                <a href="../Halaman/pelayanan.php" class="nav-link text-white text-decoration-none px-3"><span class="nav-text">PELAYANAN</span></a>

                <!-- PROFIL DESA -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-white text-decoration-none px-3" href="#" id="profilDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text">PROFIL DESA</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="profilDropdown">
                        <li><a class="dropdown-item" href="../Halaman/profil/lembaga.php">Lembaga Desa</a></li>
                        <li><a class="dropdown-item" href="../Halaman/profil/sejarahDesa.php">Sejarah Desa</a></li>
                        <li><a class="dropdown-item" href="../Halaman/profil/Demografi.php">Demografi Desa</a></li>
                    </ul>
                </div>

                <!-- PETA INTERAKTIF -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-white text-decoration-none px-3" href="#" id="petaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text">PETA INTERAKTIF</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="petaDropdown">
                        <li><a class="dropdown-item" href="../Halaman/peta/petaDesa.php">Peta Desa (UMUM)</a></li>
                    </ul>
                </div>

                <!-- Objek wisata -->
                <a href="../Halaman/wisata.php" class="nav-link text-white text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
                <!-- umkm desa -->
                <a href="../Halaman/umkmDesa.php" class="nav-link text-white text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
            </nav>
        </div>

        <!-- Hero Text (center-lower) -->
        <div class="hero-text container text-center text-white" style="max-width:56rem; z-index:16; margin-top: -40px;">
            <h1 class="display-5 fw-bold font-poppins">Selamat Datang di Desa Teniga</h1>
            <p class="fs-4 fw-medium mb-4">Desa Wisata</p>
            <a href="#" class="btn btn-primary btn-lg d-inline-flex align-items-center px-4 py-3">
                <i data-lucide="share-2" class="me-2"></i>
                MEDIA SOSIAL DESA TENIGA
            </a>
        </div>
    </header>

    <!-- NEWS SECTION -->
    <section class="py-5 bg-light" id="kabar">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2">Teniga Hari Ini</h2>
                <p class="text-muted">Berita Terkini Desa Teniga</p>
            </div>

            <div class="row g-4">
                <!-- Berita 1 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <img src="https://placehold.co/600x400/1e40af/ffffff?text=Berita+Desa+1" class="card-img-top" alt="Berita Desa" style="height:12rem;object-fit:cover;">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center text-muted small mb-2 gap-3">
                                <span><i data-lucide="calendar" class="me-1"></i> 29 Oktober 2024</span>
                                <span><i data-lucide="user" class="me-1"></i> Silvi Sri Mulyani</span>
                            </div>
                            <h5 class="card-title fw-bold mb-2">Solusi Pandemi Desa Ponggok: Kolaborasi Kreatif</h5>
                            <p class="card-text text-muted flex-grow-1">Tidak mudah menyatukan hati dan energi untuk gotong royong memulihkan perekonomian desa ini...</p>
                            <a href="#" class="mt-auto text-primary text-decoration-none small">Baca Selengkapnya <i data-lucide="arrow-right" class="ms-1"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Berita 2 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <img src="https://placehold.co/600x400/1e40af/ffffff?text=Berita+Desa+2" class="card-img-top" alt="PKK Desa Ponggok" style="height:12rem;object-fit:cover;">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center text-muted small mb-2 gap-3">
                                <span><i data-lucide="calendar" class="me-1"></i> 29 Oktober 2024</span>
                                <span><i data-lucide="user" class="me-1"></i> Silvi Sri Mulyani</span>
                            </div>
                            <h5 class="card-title fw-bold mb-2">PKK Desa Ponggok Wani Sinau</h5>
                            <p class="card-text text-muted flex-grow-1">Senin, 23 November 2020 Tim Penggerak PKK Desa Ponggok mengikuti webinar...</p>
                            <a href="#" class="mt-auto text-primary text-decoration-none small">Baca Selengkapnya <i data-lucide="arrow-right" class="ms-1"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Berita 3 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <img src="https://placehold.co/600x400/1e40af/ffffff?text=Berita+Desa+3" class="card-img-top" alt="Pongchips Halal" style="height:12rem;object-fit:cover;">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center text-muted small mb-2 gap-3">
                                <span><i data-lucide="calendar" class="me-1"></i> 29 Oktober 2024</span>
                                <span><i data-lucide="user" class="me-1"></i> Silvi Sri Mulyani</span>
                            </div>
                            <h5 class="card-title fw-bold mb-2">Sertifikat Halal untuk PONGCHIP</h5>
                            <p class="card-text text-muted flex-grow-1">Cemilan berbahan dasar ikan nila, produk lokal desa Ponggok; Pongchips...</p>
                            <a href="#" class="mt-auto text-primary text-decoration-none small">Baca Selengkapnya <i data-lucide="arrow-right" class="ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lihat Semua -->
            <div class="text-center mt-5">
                <a href="#" class="btn btn-primary btn-lg rounded-pill small ">LIHAT SEMUA BLOG</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-#c519b text-white text-center py-4">
        <div class="container">
            <p class="small mb-0">
                Hak Cipta ©2025 Teniga. Universitas Bumigora | Diciptakan oleh Julbedong
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();

        (function() {
            const LONGPRESS_MS = 400;

            document.querySelectorAll('.dropdown').forEach(drop => {
                const toggle = drop.querySelector('.dropdown-toggle');
                if (!toggle) return;

                if (!toggle.dataset.href) {
                    const firstItem = drop.querySelector('.dropdown-item[href]');
                    if (firstItem) toggle.dataset.href = firstItem.getAttribute('href');
                }

                let pressTimer = null;
                const startPress = (e) => {
                    if (!toggle.dataset.href) return;
                    pressTimer = Date.now();
                };

                const endPress = (e) => {
                    if (!toggle.dataset.href || pressTimer === null) return;
                    const dur = Date.now() - pressTimer;
                    pressTimer = null;
                    // long-press -> navigate
                    if (dur >= LONGPRESS_MS) {
                        window.location.href = toggle.dataset.href;
                    }
                };

                toggle.addEventListener('touchstart', startPress, {
                    passive: true
                });
                toggle.addEventListener('mousedown', startPress);
                toggle.addEventListener('touchend', endPress);
                toggle.addEventListener('mouseup', endPress);

                toggle.addEventListener('click', function(e) {
                    const href = this.dataset.href;
                    const isOpen = drop.classList.contains('show');
                    if (href && isOpen) {
                        e.preventDefault();
                        e.stopPropagation();
                        window.location.href = href;
                    }
                });
            });
        })();

        (function() {
            if ('ontouchstart' in window) return;
            if (window.matchMedia && !window.matchMedia('(hover: hover)').matches) return;

            document.querySelectorAll('.dropdown').forEach(drop => {
                const toggle = drop.querySelector('.dropdown-toggle');
                if (!toggle) return;

                let bs = bootstrap.Dropdown.getOrCreateInstance(toggle);
                let hideTimer = null;

                drop.addEventListener('mouseenter', () => {
                    if (hideTimer) {
                        clearTimeout(hideTimer);
                        hideTimer = null;
                    }
                    bs.show();
                });

                drop.addEventListener('mouseleave', () => {
                    hideTimer = setTimeout(() => {
                        bs.hide();
                    }, 50);
                });
            });
        })();
    </script>
</body>

</html>