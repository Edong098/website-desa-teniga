<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../database/dbConnect.php";

if (!isset($konek) || $konek->connect_errno) {
    die("Koneksi database gagal.");
}

// HELPER
function formatDateIndo($dateStr)
{
    if (empty($dateStr) || $dateStr === '0000-00-00') return '';

    $months = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    $ts = strtotime($dateStr);
    if ($ts === false) return $dateStr;

    return date('j', $ts) . ' ' . $months[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

$three_cards = [];

$query = "SELECT judul, ringkasan, gambar, harga 
          FROM tb_berita 
          ORDER BY id ASC 
          LIMIT 6";

$result = $konek->query($query);

if (!$result) {
    die("Query error: " . $konek->error);
}

while ($row = $result->fetch_assoc()) {

    $image = !empty($row['gambar'])
        ? "../uploads/berita/" . $row['gambar']
        : "https://placehold.co/400x250/4a86e8/ffffff?text=No+Image";

    $excerpt = !empty($row['ringkasan'])
        ? (mb_strlen($row['ringkasan']) > 100
            ? mb_substr($row['ringkasan'], 0, 100) . '...'
            : $row['ringkasan'])
        : 'No description available.';

    $three_cards[] = [
        'title'   => htmlspecialchars($row['judul'] ?? 'Tanpa Judul'),
        'excerpt' => htmlspecialchars($excerpt),
        'image'   => $image,
        'harga'   => (int)($row['harga'] ?? 0)
    ];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kabar Desa Teniga</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/CSS/pakettour.css">
    <script src="../assets/JS/pakettour.js" defer></script>
</head>

<body class="bg-light">
    <!-- Header -->
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
                <a href="../Halaman/pakettour.php" class="nav-link active text-decoration-none px-3"><span class="nav-text">TOUR PACKAGES</span></a>

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
                <a href="../Halaman/umkmDesa.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
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
            <a href="../Halaman/pakettour.php" class="nav-link active text-decoration-none px-3"><span class="nav-text">TOUR PACKAGES</span></a>

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
            <a href="../Halaman/umkmDesa.php" class="nav-link text-black  text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
        </div>
    </header>

    <section class="pt-5 pb-4 bg-white">
        <div class="container text-center">
            <h2 class="display-6 fw-bold font-poppins text-dark-blue mb-2">Choose Your Tour Adventure <br> in Desa Wisata Teniga</h2>
            <p class="fs-5 text-muted">Pilih paket liburan sesuai kebutuhan dan rasakan petualangan seru bersama alam dan budaya lokal!</p>
            <hr class="w-25 mx-auto">
        </div>
    </section>

    <!-- Tour Packages Section -->
    <section class="py-5 bg-light">
        <div class="container">

            <?php if (!empty($three_cards)): ?>
                <div class="row g-3 justify-content-center">
                    <?php foreach ($three_cards as $card): ?>

                        <?php $waText = urlencode("Halo, saya tertarik dengan paket wisata: " . $card['title']); ?>

                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="card tour-card h-100 shadow border-0 rounded-4 overflow-hidden">
                                <img src="<?php echo htmlspecialchars($card['image']); ?>"
                                    class="card-img-top"
                                    alt="<?php echo htmlspecialchars($card['title']); ?>"
                                    loading="lazy" />

                                <div class="card-body d-flex flex-column p-3">
                                    <h6 class="fw-bold text-dark-blue mb-2">
                                        <?php echo htmlspecialchars($card['title']); ?>
                                    </h6>

                                    <p class="small text-muted flex-grow-1">
                                        <?php echo htmlspecialchars(substr($card['excerpt'], 0, 80)) . "..."; ?>
                                    </p>

                                    <div class="mt-2">
                                        <span class="text-dark fw-semibold d-block mb-1 small">
                                            Start From
                                        </span>
                                        <h6 class="fw-bold text-warning mb-2">
                                            Mulai dari <?= number_format($card['harga'], 0, ',', '.'); ?>
                                        </h6>

                                        <a href="https://wa.me/6285239931263?text=<?= $waText ?>"
                                            target="_blank"
                                            class="btn btn-warning w-100 fw-semibold btn-sm rounded-pill">
                                            Book Now →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

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
                                loading="lazy"
                                style="max-height: 120px; width: auto; object-fit: contain;" />
                            <img
                                src="../assets/img/Logo-kosabangsa.jpg"
                                alt="Logo Kosabangsa"
                                class="footer-logo"
                                loading="lazy"
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