<?php
include "../database/dbConnect.php";

$conn = $konek;

if ($conn) {
    // Ambil semua data UMKM dari tabel tb_umkm
    $all_umkm = [];
    $query = "SELECT * FROM tb_umkm ORDER BY tanggal_input DESC";
    $result = $conn->query($query);

    // KODE BARU YANG BENAR:
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            // Gambar produk (Logika ini sebenarnya tidak perlu di loop ini, tapi tidak masalah)
            $image_path = htmlspecialchars($row['gambar_produk'] ?? '');
            $image = !empty($image_path)
                ? "../uploads/umkm/" . $image_path
                : "https://placehold.co/800x400/a2d2ff/000000?text=Produk+UMKM+Teniga";

            // Format harga (Logika ini juga tidak perlu di loop ini)
            $harga_produk = $row['harga_produk'] ?? 0;
            $harga_display = 'Rp ' . number_format($harga_produk, 0, ',', '.');

            // Format kontak WhatsApp (Logika ini juga tidak perlu di loop ini)
            $kontak_clean = preg_replace('/[^0-9]/', '', $row['kontak_umkm'] ?? '');
            if (!empty($kontak_clean) && substr($kontak_clean, 0, 1) === '0') {
                $kontak_clean = '62' . substr($kontak_clean, 1);
            }

            $message = "Halo, saya tertarik dengan produk *{$row['produk']}* dari *{$row['nama_umkm']}* yang ada di website Desa Wisata Teniga. Apakah produk ini masih tersedia?";
            $kontak_link = "https://wa.me/" . $kontak_clean . "?text=" . urlencode($message);

            // Susun data ke array $all_umkm - LAKUKAN DI SINI!
            $all_umkm[] = [
                'nama_umkm' => htmlspecialchars($row['nama_umkm'] ?? ''),
                'produk' => htmlspecialchars($row['produk'] ?? ''),
                'harga_produk' => $harga_produk,
                'kontak_umkm' => htmlspecialchars($row['kontak_umkm'] ?? ''),
                'alamat_umkm' => htmlspecialchars($row['alamat_umkm'] ?? ''),
                'gambar_produk' => htmlspecialchars($row['gambar_produk'] ?? '')
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKM Desa Teniga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/CSS/umkm.css">
</head>

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
                <a href="../Halaman/wisata.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
                <!-- umkm desa -->
                <a href="../Halaman/umkmDesa.php" class="nav-link text-black active text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
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
            <a href="../Halaman/wisata.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
            <!-- umkm desa -->
            <a href="../Halaman/umkmDesa.php" class="nav-link text-black active text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
        </div>
    </header>

    <section class="pt-5 pb-4 bg-white">
        <div class="container text-center">
            <h2 class="display-6 fw-bold font-poppins text-dark-blue mb-2">Discover Banana Delights in Desa Wisata Teniga</h2>
            <p class="fs-5 text-muted">Temukan berbagai olahan pisang khas Teniga — dari pisang segar alami hingga pisang sale manis dan gurih, hasil karya tangan kreatif masyarakat desa!</p>
            <hr class="w-25 mx-auto">
        </div>
    </section>

    <!-- main -->
    <section class="py-5 bg-white">
        <div class="container">
            <?php if (!empty($all_umkm)): ?>
                <div class="row g-4 justify-content-center">
                    <?php foreach ($all_umkm as $card): ?>
                        <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">
                            <div class="card shadow umkm-card text-dark new-design w-100">
                                <div class="card-image-wrapper position-relative">
                                    <img src="<?php echo '../uploads/umkm/' . htmlspecialchars($card['gambar_produk']); ?>"
                                        class="card-img-top rounded-top"
                                        alt="<?php echo htmlspecialchars($card['produk']); ?>">

                                    <div class="card-overlay-text p-3">
                                        <span class="badge rounded-pill umkm-badge mb-2 fw-medium">Produk Pisang</span>

                                        <h5 class="card-title-overlay fw-bold mb-1 line-clamp-2 text-white">
                                            <?php echo htmlspecialchars($card['produk']); ?>
                                        </h5>
                                    </div>
                                </div>

                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title mb-2 fw-bold text-black">
                                        <?php echo htmlspecialchars($card['nama_umkm']); ?>
                                    </h5>

                                    <h6 class="card-subtitle mb-3 fw-semibold text-dark">
                                        Rp <?php echo number_format($card['harga_produk']); ?>
                                    </h6>

                                    <div class="card-text text-secondary small flex-grow-1 mb-3">
                                        <div class="d-flex align-items-start mb-1">
                                            <i data-lucide="building" style="width:18px;height:18px; margin-top: 3px;"></i>
                                            <span class="ms-2 fw-semibold line-clamp-1">
                                                <?php echo htmlspecialchars($card['nama_umkm']); ?>
                                            </span>
                                        </div>

                                        <div class="d-flex align-items-start">
                                            <i data-lucide="map-pin" style="width:18px;height:18px; margin-top: 3px;"></i>
                                            <span class="ms-2 text-wrap line-clamp-2">
                                                <?php echo htmlspecialchars($card['alamat_umkm']); ?>
                                            </span>
                                        </div>
                                    </div>

                                    <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $card['kontak_umkm']); ?>?text=<?php echo urlencode('Halo, saya ingin pesan ' . $card['produk']); ?>"
                                        target="_blank"
                                        class="mt-auto wa-button btn-warning w-100 fw-semibold btn-sm rounded-pill">
                                        <i data-lucide="whatsapp" class="me-1" style="width:20px;height:20px;"></i>
                                        Hubungi Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- footer -->
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