<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../database/dbConnect.php";

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Desa Teniga</title>

    <!-- Bootstrap 5.3 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap"
        rel="stylesheet" />
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/CSS/beranda.css" />
</head>

<body class="bg-gray-50">
    <!-- HEADER + NAVBAR -->
    <header class="hero-background position-relative">
        <div
            class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>

        <div class="container position-relative py-3" style="z-index: 20">
            <div
                class="d-flex justify-content-between align-items-center w-100 position-relative"
                id="navbar-header">
                <a
                    href="#home"
                    class="d-flex align-items-center text-white text-decoration-none">
                    <img
                        src="../assets/img/logo.png"
                        alt="Logo Desa Teniga"
                        style="height: 44px; width: auto" />
                    <div
                        class="d-flex flex-column ms-1"
                        style="font-family: Paprika, system-ui">
                        <span class="fs-6 fw-bold">DESA WISATA TENIGA</span>
                        <span class="small fw-bold">TANJUNG LOMBOK UTARA</span>
                    </div>
                </a>

                <button
                    id="mobile-menu-btn"
                    class="d-lg-none text-white border-0 bg-transparent"
                    aria-label="Toggle menu">
                    <i
                        data-lucide="menu"
                        id="menu-icon"
                        style="width: 28px; height: 28px"></i>
                </button>
            </div>

            <nav
                id="main-navigation"
                class="d-none d-lg-flex justify-content-center text-white small fw-bold mt-3">
                <a
                    href="../Halaman/Beranda.php"
                    class="nav-link active text-white text-decoration-none px-3"><span class="nav-text">BERANDA</span></a>
                <a
                    href="../Halaman/pakettour.php"
                    class="nav-link text-white text-decoration-none px-3"><span class="nav-text">PAKET TOUR</span></a>

                <div class="dropdown">
                    <a
                        class="nav-link dropdown-toggle text-white text-decoration-none px-3"
                        href="#"
                        id="petaDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span class="nav-text">PETA INTERAKTIF</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="petaDropdown">
                        <li>
                            <a class="dropdown-item" href="../Halaman/peta/petaDesa.php">Peta Desa (UMUM)</a>
                        </li>
                        <li><a class="dropdown-item" href="#">Peta UMKM</a></li>
                    </ul>
                </div>
                <a
                    href="../Halaman/wisata.php"
                    class="nav-link text-white text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
                <a
                    href="../Halaman/umkmDesa.php"
                    class="nav-link text-white text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
            </nav>
        </div>

        <!-- mobile -->
        <div class="mobile-menu" id="mobile-menu">
            <div class="mobile-menu-header">
                <h5 class="fw-bold mb-0">Menu Navigasi</h5>
                <button
                    id="close-menu-btn"
                    class="border-0 bg-transparent"
                    aria-label="Close menu">
                    <i
                        data-lucide="x"
                        style="width: 24px; height: 24px; color: #333"></i>
                </button>
            </div>

            <a href="../Halaman/Beranda.php" class="mobile-nav-link active">BERANDA</a>
            <a href="../Halaman/pakettour.php" class="mobile-nav-link">PAKET TOUR</a>

            <div class="mobile-dropdown-toggle" data-target="peta">
                <span>PETA INTERAKTIF</span>
                <i data-lucide="chevron-down" class="dropdown-chevron"></i>
            </div>
            <div class="mobile-dropdown-menu" id="mobile-dropdown-peta">
                <a class="mobile-dropdown-item" href="../Halaman/peta/petaDesa.php">Peta Desa (UMUM)</a>
                <a class="dropdown-item" href="#">Peta UMKM</a>
            </div>

            <a href="../Halaman/wisata.php" class="mobile-nav-link">OBJEK WISATA</a>
            <a href="../Halaman/umkmDesa.php" class="mobile-nav-link">UMKM DESA</a>
        </div>

        <!-- HERO CONTENT WITH CARD CAROUSEL -->
        <div class="hero-content-wrapper">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left Side: Main Text and CTA -->
                    <div class="col-lg-5 hero-main-text">
                        <p
                            class="text-white small fw-semibold mb-2 text-uppercase"
                            style="letter-spacing: 2px">
                            Desa Wisata
                        </p>
                        <h1
                            class="display-4 fw-bold text-white font-poppins mb-3"
                            style="line-height: 1.2">
                            Teniga
                        </h1>
                        <p class="text-white fs-5 mb-4" style="opacity: 0.95">
                            Experience The Nature and The Life of Local People
                        </p>
                        <a
                            href="pakettour.php"
                            class="btn btn-warning btn-lg fw-bold px-4 py-3 rounded-pill">
                            Book Package
                        </a>
                    </div>

                    <!-- Right Side: Card Carousel -->
                    <div class="col-lg-7">
                        <div
                            id="heroCardCarousel"
                            class="carousel slide"
                            data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <!-- Carousel Item 1 -->
                                <div class="carousel-item active">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="hero-card">
                                                <img
                                                    src="../assets/img/herocarousel1.jpg"
                                                    alt="Ecoventure"
                                                    class="hero-card-img" />
                                                <div class="hero-card-overlay">
                                                    <h5 class="hero-card-title">
                                                        Ecoventure<br />Soft Trekking
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="hero-card">
                                                <img
                                                    src="../assets/img/herocarousel2.png"
                                                    alt="Village Life"
                                                    class="hero-card-img" />
                                                <div class="hero-card-overlay">
                                                    <h5 class="hero-card-title">
                                                        Experience A<br />Village Life Of<br />Teniga People
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="hero-card">
                                                <img
                                                    src="../assets/img/herocarousel3.png"
                                                    alt="Waterfall"
                                                    class="hero-card-img" />
                                                <div class="hero-card-overlay">
                                                    <h5 class="hero-card-title">
                                                        Gazebo<br />Chill View
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Carousel Item 2 -->
                                <div class="carousel-item">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="hero-card">
                                                <img
                                                    src="../assets/img/herocarousel4.png"
                                                    alt="Culture"
                                                    class="hero-card-img" />
                                                <div class="hero-card-overlay">
                                                    <h5 class="hero-card-title">Sky<br />View</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="hero-card">
                                                <img
                                                    src="../assets/img/herocarousel5.jpg"
                                                    alt="Beach"
                                                    class="hero-card-img" />
                                                <div class="hero-card-overlay">
                                                    <h5 class="hero-card-title">
                                                        Local<br />Cullinary
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="hero-card">
                                                <img
                                                    src="../assets/img/herocarousel666.jpg"
                                                    alt="Local Food"
                                                    class="hero-card-img" />
                                                <div class="hero-card-overlay">
                                                    <h5 class="hero-card-title">Reading<br />Comapertement</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Carousel Controls -->
                            <div class="hero-carousel-controls">
                                <button
                                    class="hero-carousel-btn"
                                    type="button"
                                    data-bs-target="#heroCardCarousel"
                                    data-bs-slide="prev">
                                    <i data-lucide="chevron-left"></i>
                                </button>
                                <button
                                    class="hero-carousel-btn"
                                    type="button"
                                    data-bs-target="#heroCardCarousel"
                                    data-bs-slide="next">
                                    <i data-lucide="chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- NEWS SECTION -->
    <section class="py-5 bg-light" id="kabar">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2">Teniga Desa Wisata</h2>
                <p class="text-muted">Find Your Peace in Teniga - Where Time Slows Down</p>
                <p> Nestled in the verdant hills of Lombok Utara, Desa Teniga offers a rare escape from the rush of modern life. Here, the rhythm of life flows with the gentle cascades of Elong Tune waterfall and the swaying of emerald rice terraces. Wake up to the chorus of tropical birds, trek through lush forests with local guides who know every hidden trail, and immerse yourself in authentic village traditions that have been preserved for generations. Whether you're learning traditional farming techniques, savoring home-cooked meals with local families, or simply breathing in the pure mountain air, Teniga invites you to disconnect from the chaos and reconnect with what truly matters. This isn't just a destination—it's a journey back to simplicity, where every moment becomes a memory and every experience touches the soul.</p>
            </div>

            <div class="container text-center">
                <div class="row">
                    <div class="col">
                        <h3>KOSABANGSA 2025 : Kolaborasi UBG dan UNRAM di Desa Teniga</h3><br>
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/nT33QXggChA" title="KOSABANGSA 2025 : Kolaborasi UBG dan UNRAM di Desa Teniga" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <br>
                    <div class="col">
                        <h3>Penyerahan Alat dan Pelatihan Kelompok Pisang Desa Teniga</h3>
                        <br>
                        <iframe src="https://drive.google.com/file/d/1Zik5jitef2NFlvY7GxhbNCtbNc5TGZih/preview" width="560" height="315" allow="autoplay"></iframe>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col">
                        <h3> Sosialisasi & Pengenalan Website Wisata <br> Desa Teniga</h3>
                        <br>
                        <iframe
                            src="https://drive.google.com/file/d/1sunm_EiniiAhZnjpYVB4sFMWvw7AKN1i/preview"
                            width="560"
                            height="315"
                            allow="autoplay"
                            style="border-radius: 12px; box-shadow: 0 6px 20px rgba(0,0,0,0.2);"></iframe>
                    </div>
                    <div class="col">
                        <h3>Chill Savvah from the Top <br> of Teniga Village</h3><br>
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/6Nf9nZp2w3w?si=wSKa-vNXrn33LGbR" title="Chill Savvah from the Top of Teniga Village" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
                <br>
            </div>

            <!-- Lihat Semua -->
            <div class="text-center mt-5">
                <a
                    href="pakettour.php"
                    class="btn btn-warning btn-lg fw-bold px-4 py-3 rounded-pill">LIHAT SEMUA PAKET WISATA</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer-modern">
        <div class="container">
            <div class="row g-5 align-items-start">
                <!-- Left Column: Logo & Description -->
                <div class="col-lg-5 col-md-12">
                    <div class="footer-brand mb-4">
                        <!-- Flex agar gambar sejajar -->
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                            <img
                                src="../assets/img/logo.png"
                                alt="Logo Desa Teniga"
                                class="footer-logo"
                                style="max-height: 126px; width: auto; object-fit: contain;" />
                            <img
                                src="../assets/img/Logo-kosabangsa.jpg"
                                alt="Logo Kosabangsa"
                                class="footer-logo"
                                style="max-height: 126px; width: auto; object-fit: contain;" />
                        </div>

                        <h4 class="text-black fw-bold mb-2">Desa Wisata Teniga</h4>
                        <p class="text-black-50 mb-4">
                            Experience The Nature and The Life of Local People in Desa Wisata Teniga.
                        </p>
                    </div>
                </div>

                <!-- Middle Column: Information -->
                <div class="col-lg-3 col-md-6 ms-lg-3">
                    <h5 class="text-black fw-bold mb-4">Information</h5>
                    <ul class="footer-links list-unstyled">
                        <li><a href="#" class="text-black-50 text-decoration-none">About</a></li>
                        <li><a href="#" class="text-black-50 text-decoration-none">Tour Packages</a></li>
                        <li><a href="#" class="text-black-50 text-decoration-none">Events & Programs</a></li>
                    </ul>
                </div>

                <!-- Right Column: Contact Us -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-black fw-bold mb-4">Contact Us</h5>
                    <div class="footer-contact">
                        <div class="d-flex align-items-center mb-3">
                            <i data-lucide="phone" class="text-black me-2"></i>
                            <a href="tel:+6287822618933" class="text-black-50 text-decoration-none">
                                +62 878-2261-8933
                            </a>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <i data-lucide="mail" class="text-black me-2"></i>
                            <a href="mailto:desateniga@gmail.com" class="text-black-50 text-decoration-none">
                                desateniga@gmail.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="footer-bottom text-center mt-5 pt-4">
                <p class="text-black-50 small mb-0">
                    Copyright 2025 © Pokdarwis Teniga x Universitas Bumigora
                </p>
            </div>
        </div>
    </footer>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();

        (function() {
            const LONGPRESS_MS = 400;

            document.querySelectorAll(".dropdown").forEach((drop) => {
                const toggle = drop.querySelector(".dropdown-toggle");
                if (!toggle) return;

                if (!toggle.dataset.href) {
                    const firstItem = drop.querySelector(".dropdown-item[href]");
                    if (firstItem) toggle.dataset.href = firstItem.getAttribute("href");
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

                toggle.addEventListener("touchstart", startPress, {
                    passive: true,
                });
                toggle.addEventListener("mousedown", startPress);
                toggle.addEventListener("touchend", endPress);
                toggle.addEventListener("mouseup", endPress);

                toggle.addEventListener("click", function(e) {
                    const href = this.dataset.href;
                    const isOpen = drop.classList.contains("show");
                    if (href && isOpen) {
                        e.preventDefault();
                        e.stopPropagation();
                        window.location.href = href;
                    }
                });
            });
        })();

        (function() {
            if ("ontouchstart" in window) return;
            if (window.matchMedia && !window.matchMedia("(hover: hover)").matches)
                return;

            document.querySelectorAll(".dropdown").forEach((drop) => {
                const toggle = drop.querySelector(".dropdown-toggle");
                if (!toggle) return;

                let bs = bootstrap.Dropdown.getOrCreateInstance(toggle);
                let hideTimer = null;

                drop.addEventListener("mouseenter", () => {
                    if (hideTimer) {
                        clearTimeout(hideTimer);
                        hideTimer = null;
                    }
                    bs.show();
                });

                drop.addEventListener("mouseleave", () => {
                    hideTimer = setTimeout(() => {
                        bs.hide();
                    }, 50);
                });
            });
        })();

        (function() {
            const mobileMenu = document.getElementById("mobile-menu");
            const openBtn = document.getElementById("mobile-menu-btn");
            const closeBtn = document.getElementById("close-menu-btn");
            const dropdownToggles = document.querySelectorAll(
                ".mobile-dropdown-toggle"
            );

            function toggleMobileMenu() {
                mobileMenu.classList.toggle("show");
                document.body.classList.toggle("no-scroll");
            }

            openBtn.addEventListener("click", toggleMobileMenu);
            closeBtn.addEventListener("click", toggleMobileMenu);

            // Toggle untuk Mobile Dropdown
            dropdownToggles.forEach((toggle) => {
                toggle.addEventListener("click", () => {
                    const targetId = `mobile-dropdown-${toggle.dataset.target}`;
                    const targetMenu = document.getElementById(targetId);
                    const chevron = toggle.querySelector(".dropdown-chevron");

                    targetMenu.classList.toggle("open");
                    chevron.classList.toggle("rotate-180");
                });
            });
        })();
    </script>
</body>

</html>