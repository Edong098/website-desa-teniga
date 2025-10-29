<?php
include "../database/dbConnect.php";

require_once "../database/dbConnect.php";
$conn = $konek ?? $mysqli ?? null;

if (!$conn) {
    error_log("Database connection failed");
    die("Database connection not available");
}


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
    $d = (int)date('j', $ts);
    $m = (int)date('n', $ts);
    $y = date('Y', $ts);
    return $d . ' ' . $months[$m] . ' ' . $y;
}

$carousel_items = [];
$three_cards = [];
$all_news = [];

$limit = 3;
$featured_count = 4;
$cards_count = 3;
$exclude_count = $featured_count + $cards_count;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

if ($conn) {
    // 1) Hitung total dan halaman
    $total_result = $conn->query("SELECT COUNT(*) AS total FROM tb_berita");
    $total_row = $total_result ? $total_result->fetch_assoc() : ['total' => 0];
    $total_records = (int)$total_row['total'];

    $displayable_records = max(0, $total_records - $exclude_count);
    $total_pages = $displayable_records > 0 ? (int)ceil($displayable_records / $limit) : 1;

    if ($page > $total_pages) $page = $total_pages;
    if ($page < 1) $page = 1;

    // 2) Carousel (4 item terbaru)
    $carousel_query = "SELECT * FROM tb_berita ORDER BY tanggal DESC LIMIT {$featured_count}";
    $carousel_result = $conn->query($carousel_query);
    if ($carousel_result) {
        while ($row = $carousel_result->fetch_assoc()) {
            $image = !empty($row['gambar']) ? "../uploads/berita/" . $row['gambar'] : "https://placehold.co/1200x500/0c519b/ffffff?text=Berita+Unggulan";
            $link = !empty($row['link']) ? $row['link'] : 'detailBerita.php?id=' . ($row['id'] ?? '');

            $carousel_items[] = [
                'title' => htmlspecialchars($row['judul'] ?? 'Berita Unggulan'),
                'excerpt' => htmlspecialchars(!empty($row['ringkasan']) ? (mb_strlen($row['ringkasan']) > 150 ? mb_substr($row['ringkasan'], 0, 150) . '...' : $row['ringkasan']) : ''),
                'image' => $image,
                'link' => $link,
                'date' => !empty($row['tanggal']) ? formatDateIndo($row['tanggal']) : '',
                'category' => htmlspecialchars($row['kategori'] ?? 'Umum')
            ];
        }
    }

    // 3) Tiga kartu pilihan (3 item setelah carousel)
    $three_cards_query = "SELECT * FROM tb_berita ORDER BY tanggal DESC LIMIT {$cards_count} OFFSET {$featured_count}";
    $three_cards_result = $conn->query($three_cards_query);
    if ($three_cards_result) {
        while ($row = $three_cards_result->fetch_assoc()) {
            $image = !empty($row['gambar']) ? "../uploads/berita/" . $row['gambar'] : "https://placehold.co/400x300/4a86e8/ffffff?text=Artikel+Pilihan";
            $link = !empty($row['link']) ? $row['link'] : 'detailBerita.php?id=' . ($row['id'] ?? '');

            $three_cards[] = [
                'title' => htmlspecialchars($row['judul'] ?? 'Artikel Pilihan'),
                'excerpt' => htmlspecialchars(!empty($row['ringkasan']) ? (mb_strlen($row['ringkasan']) > 80 ? mb_substr($row['ringkasan'], 0, 80) . '...' : $row['ringkasan']) : ''),
                'image' => $image,
                'link' => $link,
                'date' => !empty($row['tanggal']) ? formatDateIndo($row['tanggal']) : '',
                'category' => htmlspecialchars($row['kategori'] ?? 'Umum')
            ];
        }
    }

    // 4) Berita lainnya berdasarkan pagination — hanya jika ada record yang ditampilkan
    if ($displayable_records > 0) {
        $base_offset = ($page - 1) * $limit;
        $offset = $base_offset + $exclude_count;
        $all_news_query = "SELECT * FROM tb_berita ORDER BY tanggal DESC LIMIT {$limit} OFFSET {$offset}";
        $all_news_result = $conn->query($all_news_query);
        if ($all_news_result) {
            while ($row = $all_news_result->fetch_assoc()) {
                $image = !empty($row['gambar']) ? "../uploads/berita/" . $row['gambar'] : "https://placehold.co/400x300/e8c24a/ffffff?text=Berita+Lainnya";
                $link = !empty($row['link']) ? $row['link'] : 'detailBerita.php?id=' . ($row['id'] ?? '');

                $all_news[] = [
                    'title' => htmlspecialchars($row['judul'] ?? 'Berita Lainnya'),
                    'excerpt' => htmlspecialchars(!empty($row['ringkasan']) ? (mb_strlen($row['ringkasan']) > 80 ? mb_substr($row['ringkasan'], 0, 80) . '...' : $row['ringkasan']) : ''),
                    'image' => $image,
                    'link' => $link,
                    'date' => !empty($row['tanggal']) ? formatDateIndo($row['tanggal']) : '',
                    'category' => htmlspecialchars($row['kategori'] ?? 'Umum')
                ];
            }
        }
    } else {
        // tidak ada record yang bisa ditampilkan di bagian "Berita Lainnya"
        $all_news = [];
    }
} else {
    error_log('Database connection error in berita.php');
    $total_pages = 1;
    $page = 1;
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
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/CSS/beritaDesa.css">
</head>

<body class="bg-light">

    <header class="hero-background position-relative">
        <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>

        <div class="container position-relative py-3" style="z-index: 20;">

            <div class="d-flex justify-content-between align-items-center w-100 position-relative"
                style="margin-left: 10.5%; transform: translateY(8px); margin-bottom: -9px;">
                <a href="../Halaman/Beranda.php" class="d-flex align-items-center text-black text-decoration-none ms-3 ms-md-0">
                    <img src="../assets/img/CDR_LOGO_DESA.png"
                        alt="Logo Desa Teniga"
                        style="height:40px; margin-bottom: 2px;">
                    <div class="d-flex flex-column ms-2">
                        <span class="fs-6 fw-bold">DESA TENIGA</span>
                        <span class="small fw-bold">TANJUNG LOMBOK UTARA</span>
                    </div>
                </a>

                <button id="mobile-menu-btn" class="d-lg-none text-black border-0 bg-transparent me-3 me-md-0" aria-label="Toggle menu">
                    <i data-lucide="menu" style="width:28px;height:28px"></i>
                </button>
            </div>

            <nav id="main-navigation" class="d-none d-lg-flex justify-content-center text-black small fw-bold mt-4 py-1">
                <a href="../Halaman/Beranda.php" class="nav-link text-decoration-none px-3"><span class="nav-text">BERANDA</span></a>
                <a href="../Halaman/berita.php" class="nav-link active text-decoration-none px-3"><span class="nav-text">KABAR DESA</span></a>
                <a href="../Halaman/pelayanan.php" class="nav-link text-decoration-none px-3"><span class="nav-text">PELAYANAN</span></a>

                <div class="dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#home" id="profilDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text me-1">PROFIL DESA</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="profilDropdown">
                        <li><a class="dropdown-item" href="../Halaman/profil/lembaga.php">Lembaga Desa</a></li>
                        <li><a class="dropdown-item" href="../Halaman/profil/sejarahDesa.php">Sejarah Desa</a></li>
                        <li><a class="dropdown-item" href="../Halaman/profil/Demografi.php">Demografi Desa</a></li>
                    </ul>
                </div>

                <div class="dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="petaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text me-1">PETA INTERAKTIF</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="petaDropdown">
                        <li><a class="dropdown-item" href="../Halaman/peta/petaDesa.php">Peta Desa (Umum)</a></li>
                    </ul>
                </div>

                <a href="../Halaman/wisata.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
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

            <a href="../Halaman/Beranda.php" class="nav-link text-black py-2"><span class="nav-text">BERANDA</span></a>
            <a href="../Halaman/berita.php" class="nav-link text-black py-2"><span class="nav-text">KABAR DESA</span></a>
            <a href="../Halaman/pelayanan.php" class="nav-link text-black py-2"><span class="nav-text">PELAYANAN</span></a>

            <div class="dropdown w-100">
                <button class="dropdown-toggle w-100 text-start bg-transparent border-0 py-2 px-0 fw-bold" data-bs-toggle="collapse">
                    PROFIL DESA
                </button>
                <div id="profilMenu" class="collapse ps-3">
                    <a class="dropdown-item py-2" href="../Halaman/profil/lembaga.php">Lembaga Desa</a>
                    <a class="dropdown-item py-2" href="../Halaman/profil/sejarahDesa.php">Sejarah Desa</a>
                    <a class="dropdown-item py-2" href="../Halaman/profil/Demografi.php">Demografi Desa</a>
                </div>
            </div>

            <div class="dropdown w-100">
                <button class="dropdown-toggle w-100 text-start bg-transparent border-0 py-2 px-0 fw-bold" data-bs-toggle="collapse">
                    PETA INTERAKTIF
                </button>
                <div id="petaMenu" class="collapse ps-3">
                    <a class="dropdown-item py-2" href="../Halaman/peta/petaDesa.php">Peta Desa (Umum)</a>
                    <a class="dropdown-item py-2" href="#">Peta UMKM</a>
                </div>
            </div>

            <a href="../Halaman/wisata.php" class="nav-link text-black py-2"><span class="nav-text">OBJEK WISATA</span></a>
            <a href="../Halaman/umkmDesa.php" class="nav-link text-black py-2"><span class="nav-text">UMKM DESA</span></a>
        </div>
    </header>

    <section class="pt-5 pb-4 bg-white">
        <div class="container text-center">
            <h2 class="display-6 fw-bold font-poppins text-dark-blue mb-2">Kabar Desa Hari Ini</h2>
            <p class="fs-5 text-muted">Berita dan informasi yang paling menonjol dari Desa Teniga</p>
            <hr class="w-25 mx-auto">
        </div>
    </section>

    <!-- halaman carousel -->
    <section class="pb-5 bg-white">
        <div class="container">
            <?php if (!empty($carousel_items)): ?>
                <div id="newsCarousel" class="carousel slide elegant-carousel" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php for ($i = 0; $i < count($carousel_items); $i++): ?>
                            <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="<?php echo $i; ?>" class="<?php echo $i === 0 ? 'active' : ''; ?>" aria-current="<?php echo $i === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $i + 1; ?>"></button>
                        <?php endfor; ?>
                    </div>

                    <div class="carousel-inner rounded-2 overflow-hidden">
                        <?php foreach ($carousel_items as $index => $item): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <a href="<?php echo htmlspecialchars($item['link']); ?>" class="text-decoration-none text-dark d-block">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" class="d-block w-100 carousel-img" alt="<?php echo htmlspecialchars($item['title']); ?>">
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

    <!-- halaman pilihan -->
    <section class="py-5 bg-light">
        <div class="container">
            <h3 class="fw-bold mb-4 text-dark-blue">Artikel Pilihan</h3>
            <?php if (!empty($three_cards)): ?>
                <div class="row g-4">
                    <?php foreach ($three_cards as $card): ?>
                        <div class="col-12 col-md-6 col-lg-4">
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
            <?php endif; ?>

            <?php if (!empty($all_news)): ?>
                <h3 class="fw-bold mt-5 mb-4 text-dark-blue">Berita Lainnya</h3>

                <div class="row g-4">
                    <?php foreach ($all_news as $news_item): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <a href="<?php echo htmlspecialchars($news_item['link']); ?>" class="card h-100 shadow-lg news-card elegant-card text-decoration-none text-dark">
                                <img src="<?php echo htmlspecialchars($news_item['image']); ?>" class="card-img-top rounded-top" alt="<?php echo htmlspecialchars($news_item['title']); ?>" style="height:12rem;object-fit:cover;">
                                <div class="card-body d-flex flex-column p-4">
                                    <span class="badge rounded-pill bg-primary mb-2" style="width: fit-content;"><?php echo htmlspecialchars($news_item['category']); ?></span>
                                    <h5 class="card-title fw-bold mb-2 text-dark-blue line-clamp-2"><?php echo htmlspecialchars($news_item['title']); ?></h5>
                                    <p class="text-muted small mb-3"><i data-lucide="calendar" style="width:14px;height:14px;"></i> <?php echo htmlspecialchars($news_item['date']); ?></p>
                                    <p class="card-text text-secondary flex-grow-1 line-clamp-3"><?php echo htmlspecialchars($news_item['excerpt']); ?></p>
                                    <span class="mt-auto text-primary small fw-semibold">Baca Selengkapnya <i data-lucide="arrow-right" class="ms-1" style="width:14px;height:14px;"></i></span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation" class="mt-5 modern-pagination">
                        <ul class="pagination justify-content-center">
                            <!-- Prev -->
                            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo max(1, $page - 1); ?>" aria-label="Previous">
                                    <i data-lucide="chevron-left" style="width:18px; transform: translateY(-2px);"></i>
                                </a>
                            </li>

                            <?php
                            // LOGIC PAGINATION 5 HALAMAN (window)
                            $max_links = 5;
                            $half_window = floor($max_links / 2);

                            $start_page = max(1, $page - $half_window);
                            $end_page = min($total_pages, $page + $half_window);

                            if ($end_page - $start_page + 1 < $max_links) {
                                if ($start_page > 1) {
                                    $start_page = max(1, $end_page - $max_links + 1);
                                } elseif ($end_page < $total_pages) {
                                    $end_page = min($total_pages, $start_page + $max_links - 1);
                                }
                            }

                            // Tampilkan halaman 1 dan elipsis jika perlu
                            if ($start_page > 1) {
                                echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                                if ($start_page > 2) {
                                    echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                                }
                            }

                            // Halaman tengah
                            for ($i = $start_page; $i <= $end_page; $i++): ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor;

                            // Elipsis dan halaman terakhir
                            if ($end_page < $total_pages) {
                                if ($end_page < $total_pages - 1) {
                                    echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                                }
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '">' . $total_pages . '</a></li>';
                            }
                            ?>

                            <!-- Next -->
                            <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo min($total_pages, $page + 1); ?>" aria-label="Next">
                                    <i data-lucide="chevron-right" style="width:18px;height:18px;"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (empty($three_cards) && empty($all_news)): ?>
                <div class="alert alert-info text-center shadow-sm mt-4">Tidak ada artikel lain yang tersedia saat ini.</div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="bg-primary text-white text-center py-4">
        <div class="container">
            <p class="small mb-0">Hak Cipta © 2025 Pemerintah Desa Teniga. Semua hak dilindungi undang-undang. | Didukung Program Kosabangsa
                <br>Universitas Bumigora | Dibuat oleh Ahmad Jul Hadi
            </p>
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