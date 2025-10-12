<?php
include "../database/dbConnect.php";

$conn = null;
if (isset($konek)) {
    $conn = $konek;
}

$carousel_items = [];
$three_cards = [];
$all_news = [];

$limit = 9;

if ($conn) {
    $carousel_query = "SELECT * FROM tb_berita ORDER BY tanggal DESC LIMIT 4";
    $carousel_result = $conn->query($carousel_query);
    if ($carousel_result) {
        while ($row = $carousel_result->fetch_assoc()) {
            $image = !empty($row['gambar']) ? "../assets/img/" . $row['gambar'] : "https://placehold.co/1200x500/0c519b/ffffff?text=Berita+Unggulan";
            $link = !empty($row['link']) ? $row['link'] : 'detailBerita.php?id=' . ($row['id'] ?? '');

            $carousel_items[] = [
                'title' => !empty($row['judul']) ? $row['judul'] : 'Berita Unggulan',
                'excerpt' => !empty($row['ringkasan']) ? substr($row['ringkasan'], 0, 150) . '...' : 'Ringkasan singkat berita unggulan.',
                'image' => $image,
                'link' => $link,
                'date' => !empty($row['tanggal']) ? date('d F Y', strtotime($row['tanggal'])) : '',
                'category' => $row['kategori'] ?? 'Umum'
            ];
        }
    }

    // MENGAMBIL BERITA COURASEL 
    $three_cards_query = "SELECT * FROM tb_berita ORDER BY tanggal DESC LIMIT 3 OFFSET 4";
    $three_cards_result = $conn->query($three_cards_query);
    if ($three_cards_result) {
        while ($row = $three_cards_result->fetch_assoc()) {
            $image = !empty($row['gambar']) ? "../assets/img/" . $row['gambar'] : "https://placehold.co/400x300/4a86e8/ffffff?text=Artikel+Pilihan";
            $link = !empty($row['link']) ? $row['link'] : 'detailBerita.php?id=' . ($row['id'] ?? '');

            $three_cards[] = [
                'title' => !empty($row['judul']) ? $row['judul'] : 'Artikel Pilihan',
                'excerpt' => !empty($row['ringkasan']) ? substr($row['ringkasan'], 0, 80) . '...' : 'Ringkasan singkat.',
                'image' => $image,
                'link' => $link,
                'date' => !empty($row['tanggal']) ? date('d F Y', strtotime($row['tanggal'])) : '',
                'category' => $row['kategori'] ?? 'Umum'
            ];
        }
    }

    // PAGINATION
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;
    $total_result = $conn->query("SELECT COUNT(*) AS total FROM tb_berita");
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);

    $exclude_count = 7;

    $all_news_query = "SELECT * FROM tb_berita 
                       ORDER BY tanggal DESC 
                       LIMIT $limit OFFSET " . ($offset + $exclude_count);

    $all_news_result = $conn->query($all_news_query);

    if ($all_news_result) {
        while ($row = $all_news_result->fetch_assoc()) {
            $image = !empty($row['gambar']) ? "../assets/img/" . $row['gambar'] : "https://placehold.co/400x300/e8c24a/ffffff?text=Berita+Lainnya";
            $link = !empty($row['link']) ? $row['link'] : 'detailBerita.php?id=' . ($row['id'] ?? '');

            $all_news[] = [
                'title' => !empty($row['judul']) ? $row['judul'] : 'Berita Lainnya',
                'excerpt' => !empty($row['ringkasan']) ? substr($row['ringkasan'], 0, 80) . '...' : 'Ringkasan singkat berita.',
                'image' => $image,
                'link' => $link,
                'date' => !empty($row['tanggal']) ? date('d F Y', strtotime($row['tanggal'])) : '',
                'category' => $row['kategori'] ?? 'Umum'
            ];
        }
    }
} else {
    error_log('Database connection error in berita.php');
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kabar Desa Teniga</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/CSS/beritaDesa.css">
</head>

<body class="bg-light">

    <!-- HEADER: HANYA NAVBAR DI BAGIAN HERO -->
    <header class="hero-background position-relative">
        <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>

        <!-- Navbar -->
        <div class="container position-relative py-3" style="z-index: 20;">

            <!-- Baris Logo -->
            <div class="d-flex justify-content-between align-items-center w-100 position-relative"
                style="margin-left: 12%; transform: translateY(8px); margin-bottom: -9px;">
                <a href="../Halaman/Beranda.php" class="d-flex align-items-center text-black text-decoration-none ms-3 ms-md-0">
                    <img src="../assets/img/CDR_LOGO_DESA.png"
                        alt="Logo Desa Teniga"
                        style="height:40px; margin-bottom: 2px;">
                    <div class="d-flex flex-column ms-2">
                        <span class="fs-6 fw-bold">DESA TENIGA</span>
                        <span class="small fw-bold">TANJUNG LOMBOK UTARA</span>
                    </div>
                </a>

                <!-- Tombol Mobile -->
                <button id="mobile-menu-btn" class="d-lg-none text-white border-0 bg-transparent me-3 me-md-0" aria-label="Toggle menu">
                    <i data-lucide="menu" style="width:28px;height:28px"></i>
                </button>
            </div>

            <!-- Baris Navigasi -->
            <nav id="main-navigation" class="d-none d-lg-flex justify-content-center text-black small fw-bold mt-4 py-1">
                <a href="../Halaman/Beranda.php" class="nav-link text-decoration-none px-3"><span class="nav-text">BERANDA</span></a>
                <a href="../Halaman/berita.php" class="nav-link active text-decoration-none px-3"><span class="nav-text">KABAR DESA</span></a>
                <a href="../Halaman/wisata.php" class="nav-link text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
                <a href="../Halaman/pelayanan.php" class="nav-link text-decoration-none px-3"><span class="nav-text">PELAYANAN</span></a>
                <a href="../Halaman/sejarahDesa.php" class="nav-link text-decoration-none px-3"><span class="nav-text">SEJARAH</span></a>

                <!-- PROFIL DESA -->
                <div class="dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="profilDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text me-1">PROFIL DESA</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="profilDropdown">
                        <li><a class="dropdown-item" href="../Halaman/profil/lembaga.php">Lembaga Desa</a></li>
                        <li><a class="dropdown-item" href="../Halaman/profil/Demografi.php">Demografi</a></li>
                    </ul>
                </div>

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
            </nav>
        </div>
    </header>

    <!-- MAIN TITLE -->
    <section class="pt-5 pb-4 bg-white">
        <div class="container text-center">
            <h2 class="display-6 fw-bold font-poppins text-dark-blue mb-2">Kabar Desa Hari Ini</h2>
            <p class="fs-5 text-muted">Berita dan informasi yang paling menonjol dari Desa Teniga</p>
            <hr class="w-25 mx-auto">
        </div>
    </section>

    <!-- CAROUSEL SECTION (1 Carousel - Cantik Design) -->
    <section class="pb-5 bg-white">
        <div class="container">
            <?php if (!empty($carousel_items)): ?>
                <div id="newsCarousel" class="carousel slide elegant-carousel" data-bs-ride="carousel">

                    <!-- Carousel Indicators -->
                    <div class="carousel-indicators">
                        <?php for ($i = 0; $i < count($carousel_items); $i++): ?>
                            <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="<?php echo $i; ?>" class="<?php echo $i === 0 ? 'active' : ''; ?>" aria-current="<?php echo $i === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $i + 1; ?>"></button>
                        <?php endfor; ?>
                    </div>

                    <div class="carousel-inner rounded-2 overflow-hidden">
                        <?php foreach ($carousel_items as $index => $item): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <a href="<?php echo htmlspecialchars($item['link']); ?>" class="text-decoration-none text-dark d-block">
                                    <!-- Image -->
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" class="d-block w-100 carousel-img" alt="<?php echo htmlspecialchars($item['title']); ?>">

                                    <!-- Caption (DI BAWAH GAMBAR) -->
                                    <div class="carousel-caption-static text-start p-4">
                                        <span class="badge bg-primary mb-1 fw-medium"><?php echo htmlspecialchars($item['category']); ?></span>
                                        <h4 class="fw-bold mb-1 text-dark-blue line-clamp-2"><?php echo htmlspecialchars($item['title']); ?></h4>
                                        <p class="small text-secondary mb-0 line-clamp-1"><?php echo htmlspecialchars($item['excerpt']); ?></p>
                                        <p class="small text-muted mb-0 mt-1"><i data-lucide="calendar" style="width:14px;height:14px;"></i> <?php echo htmlspecialchars($item['date']); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center shadow-sm">Tidak ada berita unggulan yang tersedia.</div>
            <?php endif; ?>
        </div>
    </section>

    <!-- TIGA KARTU DI BAWAH CAROUSEL (Elegant Cards) -->
    <section class="py-5 bg-light">
        <div class="container">
            <h3 class="fw-bold mb-4 text-dark-blue">Artikel Pilihan</h3>
            <?php if (!empty($three_cards)): ?>
                <div class="row g-4">
                    <?php foreach ($three_cards as $card): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <!-- elegant-card class ditambahkan untuk efek hover timbul naik -->
                            <a href="<?php echo htmlspecialchars($card['link']); ?>" class="card h-100 shadow-lg news-card elegant-card text-decoration-none text-dark">
                                <img src="<?php echo htmlspecialchars($card['image']); ?>" class="card-img-top rounded-top" alt="<?php echo htmlspecialchars($card['title']); ?>" style="height:12rem;object-fit:cover;">
                                <div class="card-body d-flex flex-column p-4">
                                    <span class="badge rounded-pill bg-primary mb-2" style="width: fit-content;"><?php echo htmlspecialchars($card['category']); ?></span>
                                    <h5 class="card-title fw-bold mb-2 text-dark-blue line-clamp-2"><?php echo htmlspecialchars($card['title']); ?></h5>
                                    <p class="text-muted small mb-3"><i data-lucide="calendar" style="width:14px;height:14px;"></i> <?php echo htmlspecialchars($card['date']); ?></p>
                                    <p class="card-text text-secondary flex-grow-1 line-clamp-3"><?php echo htmlspecialchars($card['excerpt']); ?></p>
                                    <span class="mt-auto text-primary small fw-semibold">Baca Selengkapnya <i data-lucide="arrow-right" class="ms-1" style="width:14px;height:14px;"></i></span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center shadow-sm">Tidak ada artikel pilihan saat ini.</div>
            <?php endif; ?>
        </div>
    </section>

    <!-- PAGINATION-->
    <section class="pb-5 bg-white">
        <div class="container text-center">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a href="#" class="page-link">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active">
                        <a class="page-link" href="#" aria-current="page">2</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-primary text-white text-center py-4">
        <div class="container">
            <p class="small mb-0">
                Hak Cipta ©2025 Teniga. Universitas Bumigora | Diciptakan oleh Julbedong
            </p>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        // Logika Dropdown dan Hover
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

        function setCarouselHeight() {
            const height = window.innerWidth > 992 ? '450px' : (window.innerWidth > 576 ? '300px' : '220px');
            document.querySelectorAll('.carousel-img').forEach(img => {
                img.style.height = height;
            });
        }
        window.addEventListener('resize', setCarouselHeight);
        window.onload = setCarouselHeight;
    </script>
</body>

</html>