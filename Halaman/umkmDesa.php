<?php
// DATABASE CONNECTION
require_once "../database/dbConnect.php";
$conn = isset($konek) ? $konek : null;

$produk_list = [];

if ($conn) {
    $query = "SELECT * FROM tb_produk_umkm ORDER BY tanggal_input DESC";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $produk_list[] = [
                'nama_produk' => htmlspecialchars($row['nama_produk']),
                'jenis_produk' => htmlspecialchars($row['jenis_produk']),
                'harga' => (int)$row['harga_mulai'],
                'deskripsi' => htmlspecialchars($row['deskripsi']),
                'alamat' => htmlspecialchars($row['alamat_lengkap']),
                'gambar' => htmlspecialchars($row['gambar_produk'])
            ];
        }
    }
}

// NOMOR WA PENJUAL
$wa_penjual = "6285333147733";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKM Desa Teniga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/CSS/umkm.css">
    <script src="../assets/JS/mobileMenu.js" defer></script>
</head>


<!-- Modal WhatsApp -->
<div class="modal fade" id="waModal" tabindex="-1" aria-labelledby="waModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="waModalLabel">Form Pemesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="waForm">
                    <input type="hidden" id="waProduk">
                    <div class="mb-3">
                        <label class="form-label">Nama Pemesan</label>
                        <input type="text" class="form-control" id="namaPemesan" placeholder="Masukkan nama Anda" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamatLengkap" rows="2" placeholder="Alamat pengiriman" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Pesanan</label>
                        <input type="number" class="form-control" id="jumlah" min="1" value="1" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 rounded-pill fw-semibold">
                        <i data-lucide="send" class="me-1"></i> Kirim ke WhatsApp
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- logo -->

<body class="bg-light">
    <header class="hero-background position-relative">
        <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>

        <div class="container position-relative py-3" style="z-index: 20;">
            <div class="d-flex justify-content-between align-items-center w-100 position-relative">
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
            <nav id="main-navigation"
                class="d-none d-lg-flex justify-content-center text-black small fw-bold mt-1 py-2">
                <a href="../Halaman/Beranda.php" class="nav-link text-decoration-none px-3"><span class="nav-text">BERANDA</span></a>
                <a href="../Halaman/pakettour.php" class="nav-link text-decoration-none px-3"><span class="nav-text">TOUR PACKAGES</span></a>

                <!-- PETA INTERAKTIF -->
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

                <a href="../Halaman/wisata.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
                <a href="../Halaman/umkmDesa.php" class="nav-link active text-black text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
            </nav>
        </div>

        <!-- Mobile Menu -->
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
            <?php if (!empty($produk_list)): ?>
                <div class="row g-4 justify-content-center">
                    <?php foreach ($produk_list as $produk): ?>
                        <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">
                            <div class="card shadow umkm-card w-100">

                                <div class="card-image-wrapper position-relative">
                                    <img src="../uploads/umkm/<?php echo $produk['gambar']; ?>"
                                        class="card-img-top"
                                        loading="lazy"
                                        alt="<?php echo $produk['nama_produk']; ?>">

                                    <div class="card-overlay-text p-3">
                                        <span class="badge rounded-pill umkm-badge mb-2">
                                            <?php echo $produk['jenis_produk']; ?>
                                        </span>

                                        <h5 class="fw-bold text-white line-clamp-2">
                                            <?php echo $produk['nama_produk']; ?>
                                        </h5>
                                    </div>
                                </div>

                                <div class="card-body d-flex flex-column p-4">
                                    <h6 class="fw-bold text-dark mb-1">
                                        Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
                                    </h6>

                                    <p class="text-secondary small mb-2">
                                        <?php echo $produk['deskripsi']; ?>
                                    </p>

                                    <div class="text-secondary small mb-3">
                                        <i data-lucide="map-pin" style="width:16px;height:16px"></i>
                                        <span class="ms-1"><?php echo $produk['alamat']; ?></span>
                                    </div>

                                    <button
                                        class="btn btn-warning rounded-pill mt-auto fw-semibold wa-button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#waModal"
                                        data-produk="<?php echo $produk['nama_produk']; ?>">
                                        <i data-lucide="whatsapp" class="me-1"></i>
                                        Hubungi Sekarang
                                    </button>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <br>

    <!-- footer -->
    <footer class="footer-modern bg-warning">
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
                                style="max-height: 120px; width: auto; object-fit: contain;" />
                            <img
                                src="../assets/img/Logo-kosabangsa.jpg"
                                alt="Logo Kosabangsa"
                                class="footer-logo"
                                style="max-height: 120px; width: auto; object-fit: contain;" />
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
</body>

</html>