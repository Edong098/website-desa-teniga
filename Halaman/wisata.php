<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata - Desa Teniga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="../assets/CSS/wisata.css">
</head>

<body>

    <body class="bg-light">
        <header class="hero-background position-relative">
            <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>

            <div class="container position-relative py-3" style="z-index: 20;">
                <div class="d-flex justify-content-between align-items-center w-100 position-relative"
                    style="margin-left: 10.5%; transform: translateY(8px); margin-bottom: -9px;">
                    <a href="../Halaman/Beranda.php" class="d-flex align-items-center text-black text-decoration-none ms-3 ms-md-0">
                        <img src="../assets/img/logo.png"
                            alt="Logo Desa Teniga"
                            style="height:40px; margin-bottom: 2px;">
                        <div class="d-flex flex-column ms-2" class="d-flex flex-column ms-1"
                            style="font-family: Paprika, system-ui">
                            <span class="fs-6 fw-bold">DESA WISATA TENIGA</span>
                            <span class="small fw-bold">TANJUNG LOMBOK UTARA</span>
                        </div>
                    </a>

                    <button id="mobile-menu-btn" class="d-lg-none text-black border-0 bg-transparent me-3 me-md-0" aria-label="Toggle menu">
                        <i data-lucide="menu" style="width:28px;height:28px"></i>
                    </button>
                </div>

                <!-- Baris Navigasi -->
                <nav id="main-navigation" class="d-none d-lg-flex justify-content-center text-black small fw-bold mt-4 py-1">
                    <a href="../Halaman/Beranda.php" class="nav-link text-decoration-none px-3"><span class="nav-text">BERANDA</span></a>
                    <a href="../Halaman/pakettour.php" class="nav-link text-decoration-none px-3"><span class="nav-text">TOUR PACKAGES</span></a>
                    <!-- PETA INTERAKTIF -->
                    <div class="dropdown nav-dropdown">
                        <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="petaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="nav-text me-1">PETA INTERAKTIF</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="petaDropdown">
                            <li><a class="dropdown-item" href="../Halaman/peta/petaDesa.php">Peta Desa (Umum)</a></li>
                            <li><a class="dropdown-item" href="#">Peta UMKM</a></li>
                        </ul>
                    </div>

                    <!-- Objek wisata -->
                    <a href="../Halaman/wisata.php" class="nav-link text-black active text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
                    <!-- umkm desa -->
                    <a href="../Halaman/umkmDesa.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
                </nav>
            </div>

            <div class="mobile-menu" id="mobile-menu">
                <div class="mobile-menu-header">
                    <h5 class="fw-bold mb-0">Menu Navigasi</h5>
                    <button id="close-menu-btn" class="border-0 bg-transparent" aria-label="Close menu">
                        <i data-lucide="x" style="width:24px;height:24px; color: #333;"></i>
                    </button>
                </div>

                <a href="../Halaman/Beranda.php" class="nav-link text-decoration-none px-3"><span class="nav-text">BERANDA</span></a>
                <a href="../Halaman/pakettour.php" class="nav-link text-decoration-none px-3"><span class="nav-text">TOUR PACKAGES</span></a>

                <!-- PETA INTERAKTIF -->
                <div class="dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="petaDropdown" aria-expanded="false">
                        <span class="nav-text me-1">PETA INTERAKTIF</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="petaDropdown">
                        <li><a class="dropdown-item" href="../Halaman/peta/petaDesa.php">Peta Desa (Umum)</a></li>
                        <li><a class="dropdown-item" href="#">Peta UMKM</a></li>
                    </ul>
                </div>

                <!-- Objek wisata -->
                <a href="../Halaman/wisata.php" class="nav-link text-black active text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
                <!-- umkm desa -->
                <a href="../Halaman/umkmDesa.php" class="nav-link text-black  text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
            </div>
        </header>


        <section class="py-5 bg-white">
            <div class="container text-center">
                <h2 class="display-6 fw-bold font-poppins text-dark-blue mb-2">Destinasi Wisata Desa Teniga</h2>
                <p class="fs-5 text-muted">Jelajahi keindahan dan pesona alam yang ada di Desa Teniga</p>
                <hr class="w-25 mx-auto">
            </div>
        </section>

        <section class="pb-5 bg-white">
            <div class="container-fluid px-0">
                <!-- 
            ═══════════════════════════════════════════════════════════════
            TO ADD NEW IMAGES: Copy one <div class="infinity-card">...</div> block
            and paste it in BOTH rows, TWICE per row (for infinite effect)
            ═══════════════════════════════════════════════════════════════
            -->
                <!-- Infinity Scroll Carousel - Scrolling Left -->
                <div class="infinity-scroll-wrapper mb-4">
                    <div class="infinity-scroll-container scroll-left">
                        <!-- ITEM 1 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata1.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata1.jpeg" class="infinity-card-img" alt="Gua Ratu Teniga">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Petualangan
                                        </span>
                                        <h5 class="infinity-card-title">Gua Ratu Teniga</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- ITEM 2 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata2.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata2.jpeg" class="infinity-card-img" alt="Pantai Krakas">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Pantai
                                        </span>
                                        <h5 class="infinity-card-title">Pantai Krakas</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- ITEM 3 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata3.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata3.jpeg" class="infinity-card-img" alt="Air Terjun Tiu Teja">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Alam
                                        </span>
                                        <h5 class="infinity-card-title">Air Terjun Tiu Teja</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- ITEM 4 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata4.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata4.jpeg" class="infinity-card-img" alt="Bukit Teniga">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Pegunungan
                                        </span>
                                        <h5 class="infinity-card-title">Bukit Teniga</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- DUPLICATE FOR INFINITE EFFECT - ITEM 1 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata5.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata5.jpeg" class="infinity-card-img" alt="Gua Ratu Teniga">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Petualangan
                                        </span>
                                        <h5 class="infinity-card-title">Gua Ratu Teniga</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- DUPLICATE - ITEM 2 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata6.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata6.jpeg" class="infinity-card-img" alt="Pantai Krakas">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Pantai
                                        </span>
                                        <h5 class="infinity-card-title">Pantai Krakas</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- DUPLICATE - ITEM 3 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata7.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata7.jpeg" class="infinity-card-img" alt="Air Terjun Tiu Teja">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Alam
                                        </span>
                                        <h5 class="infinity-card-title">Air Terjun Tiu Teja</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- DUPLICATE - ITEM 4 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata8.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata8.jpeg" class="infinity-card-img" alt="Bukit Teniga">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Pegunungan
                                        </span>
                                        <h5 class="infinity-card-title">Bukit Teniga</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Infinity Scroll Carousel - Scrolling Right -->
                <div class="infinity-scroll-wrapper">
                    <div class="infinity-scroll-container scroll-right">
                        <!-- ITEM 1 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata8.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata8.jpeg" class="infinity-card-img" alt="Gua Ratu Teniga">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Petualangan
                                        </span>
                                        <h5 class="infinity-card-title">Gua Ratu Teniga</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- ITEM 2 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata9.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata9.jpeg" class="infinity-card-img" alt="Pantai Krakas">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Pantai
                                        </span>
                                        <h5 class="infinity-card-title">Pantai Krakas</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- ITEM 3 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata10.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata10.jpeg" class="infinity-card-img" alt="Air Terjun Tiu Teja">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Alam
                                        </span>
                                        <h5 class="infinity-card-title">Air Terjun Tiu Teja</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- ITEM 4 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata11.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata11.jpeg" class="infinity-card-img" alt="Bukit Teniga">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Pegunungan
                                        </span>
                                        <h5 class="infinity-card-title">Bukit Teniga</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- DUPLICATE FOR INFINITE EFFECT - ITEM 1 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata12.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata12.jpeg" class="infinity-card-img" alt="Gua Ratu Teniga">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Petualangan
                                        </span>
                                        <h5 class="infinity-card-title">Gua Ratu Teniga</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- DUPLICATE - ITEM 2 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata1.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata1.jpeg" class="infinity-card-img" alt="Pantai Krakas">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Pantai
                                        </span>
                                        <h5 class="infinity-card-title">Pantai Krakas</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- DUPLICATE - ITEM 3 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata2.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata2.jpeg" class="infinity-card-img" alt="Air Terjun Tiu Teja">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Alam
                                        </span>
                                        <h5 class="infinity-card-title">Air Terjun Tiu Teja</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- DUPLICATE - ITEM 4 -->
                        <div class="infinity-card">
                            <a href="../uploads/wisata/wisata3.jpeg" class="text-decoration-none">
                                <div class="infinity-card-inner">
                                    <img src="../uploads/wisata/wisata3.jpeg" class="infinity-card-img" alt="Bukit Teniga">
                                    <div class="infinity-card-overlay">
                                        <span class="badge mb-2" style="background-color: #f4d03f; color: #333;">
                                            Pegunungan
                                        </span>
                                        <h5 class="infinity-card-title">Bukit Teniga</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </section>


        <!-- FOOTER -->
        <footer class="footer-modern py-5 bg-warning">
            <div class="container">
                <div class="row g-3">
                    <!-- Left Column: Logo & Subscribe -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-brand mb-4">
                            <img
                                src="../assets/img/logo.png"
                                alt="Logo Desa Teniga"
                                class="footer-logo mb-3" />
                            <h4 class="text-black fw-bold mb-1">Desa Wisata Teniga</h4>
                            <p class="text-black-50 mb-4">
                                Experience The Nature and The Life of Local People in Desa Wisata
                                Teniga.
                            </p>
                        </div>
                    </div>

                    <!-- Middle Column: Information -->
                    <div class="col-lg-4 col-md-6 text-lg-start text-center">
                        <h5 class="text-black fw-bold mb-3">Information</h5>
                        <ul class="footer-links list-unstyled mb-0">
                            <li><a href="#" class="text-black-50 text-decoration-none d-block mb-2">About</a></li>
                            <li><a href="#" class="text-black-50 text-decoration-none d-block mb-2">Tour Packages</a></li>
                            <li><a href="#" class="text-black-50 text-decoration-none d-block">Events & Programs</a></li>
                        </ul>
                    </div>

                    <!-- Right Column: Contact Us -->
                    <div class="col-lg-4 col-md-12 text-lg-start text-center">
                        <h5 class="text-black fw-bold mb-3">Contact Us</h5>
                        <div class="footer-contact d-inline-block text-start">
                            <div class="d-flex align-items-center mb-2 justify-content-lg-start justify-content-center">
                                <i data-lucide="phone" class="text-black me-2" style="width: 18px; height: 18px;"></i>
                                <a href="tel:+6287822618933" class="text-black-50 text-decoration-none">
                                    +62 878-2261-8933
                                </a>
                            </div>
                            <div class="d-flex align-items-center justify-content-lg-start justify-content-center">
                                <i data-lucide="mail" class="text-black me-2" style="width: 18px; height: 18px;"></i>
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Inisialisasi Lucide Icons
            lucide.createIcons();

            // Dropdown Mobile Toggle — Bisa buka & tutup kembali
            document.querySelectorAll('.mobile-menu .dropdown-toggle').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();

                    const submenu = btn.nextElementSibling;
                    const isOpen = submenu.classList.contains('show');

                    // Tutup semua submenu lain dulu
                    document.querySelectorAll('.mobile-menu .dropdown-menu.show').forEach(menu => {
                        if (menu !== submenu) {
                            menu.classList.remove('show');
                        }
                    });
                    document.querySelectorAll('.mobile-menu .dropdown-toggle.show').forEach(toggle => {
                        if (toggle !== btn) {
                            toggle.classList.remove('show');
                        }
                    });

                    // Toggle submenu yang diklik
                    submenu.classList.toggle('show', !isOpen);
                    btn.classList.toggle('show', !isOpen);
                });
            });

            // LOGIKA MENU HAMBURGER UTAMA
            (function() {
                const mobileMenu = document.getElementById('mobile-menu');
                const openBtn = document.getElementById('mobile-menu-btn');
                const closeBtn = document.getElementById('close-menu-btn');

                function toggleMobileMenu() {
                    mobileMenu.classList.toggle('show');
                    document.body.classList.toggle('no-scroll');
                }

                openBtn.addEventListener('click', toggleMobileMenu);
                closeBtn.addEventListener('click', toggleMobileMenu);
            })();
        </script>
    </body>

</html>