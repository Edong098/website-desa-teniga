<?php
// Pastikan file dbConnect.php ada dan menyediakan variabel $konek
include "../database/dbConnect.php";

$conn = null;
if (isset($konek)) {
    $conn = $konek;
}

$carousel_items = [];
$three_cards = [];
$three_more_cards = [];
$all_wisata = [];

// --- PERUBAHAN UTAMA DI SINI ---
// Batas data untuk pagination per halaman (halaman 2, 3, dst.)
$limit_per_page = 3;
// Jumlah data yang akan ditampilkan di halaman 1 di bagian 'Semua Destinasi Wisata Lainnya'
$limit_first_page = 3;

if ($conn) {
    // 1. Mengambil data untuk Carousel (Wisata Unggulan - 4 data)
    $carousel_query = "SELECT * FROM tb_wisata ORDER BY tanggal DESC LIMIT 4";
    $carousel_result = $conn->query($carousel_query);
    if ($carousel_result) {
        while ($row = $carousel_result->fetch_assoc()) {
            // Path: ../uploads/wisata/
            $image = !empty($row['gambar']) ? "../uploads/wisata/" . $row['gambar'] : "https://placehold.co/1200x500/A0D1F3/ffffff?text=Wisata+Unggulan+Belum+Ada+Gambar";
            $link = !empty($row['link']) ? $row['link'] : 'detailWisata.php?id=' . ($row['id'] ?? '');

            $carousel_items[] = [
                'title' => !empty($row['judul']) ? $row['judul'] : 'Nama Wisata Unggulan',
                'excerpt' => !empty($row['ringkasan']) ? substr($row['ringkasan'], 0, 150) . '...' : 'Ringkasan singkat objek wisata unggulan, deskripsikan daya tarik utamanya.',
                'image' => $image,
                'link' => $link,
                'date' => !empty($row['tanggal']) ? date('d F Y', strtotime($row['tanggal'])) : 'Belum Tersedia',
                'category' => $row['kategori'] ?? 'Alam'
            ];
        }
    }

    // 2. Mengambil 3 Wisata Pilihan di bawah Carousel (Offset 4, Limit 3)
    // Dimulai setelah 4 data carousel
    $three_cards_query = "SELECT * FROM tb_wisata ORDER BY tanggal DESC LIMIT 3 OFFSET 4";
    $three_cards_result = $conn->query($three_cards_query);
    if ($three_cards_result) {
        while ($row = $three_cards_result->fetch_assoc()) {
            // Path: ../uploads/wisata/
            $image = !empty($row['gambar']) ? "../uploads/wisata/" . $row['gambar'] : "https://placehold.co/400x300/F4D03F/333333?text=Wisata+Pilihan+1+Gambar";
            $link = !empty($row['link']) ? $row['link'] : 'detailWisata.php?id=' . ($row['id'] ?? '');

            $three_cards[] = [
                'title' => !empty($row['judul']) ? $row['judul'] : 'Nama Destinasi Pilihan',
                'excerpt' => !empty($row['ringkasan']) ? substr($row['ringkasan'], 0, 80) . '...' : 'Deskripsi singkat tentang destinasi ini.',
                'image' => $image,
                'link' => $link,
                'date' => !empty($row['tanggal']) ? date('d F Y', strtotime($row['tanggal'])) : 'Belum Tersedia',
                'category' => $row['kategori'] ?? 'Budaya'
            ];
        }
    }

    // 3. Mengambil 3 Kartu Tambahan (Offset 7, Limit 3)
    // Dimulai setelah 7 data sebelumnya (4+3)
    $three_more_cards_query = "SELECT * FROM tb_wisata ORDER BY tanggal DESC LIMIT 3 OFFSET 7";
    $three_more_cards_result = $conn->query($three_more_cards_query);
    if ($three_more_cards_result) {
        while ($row = $three_more_cards_result->fetch_assoc()) {
            // Path: ../uploads/wisata/
            $image = !empty($row['gambar']) ? "../uploads/wisata/" . $row['gambar'] : "https://placehold.co/400x300/F4D03F/333333?text=Wisata+Pilihan+2+Gambar";
            $link = !empty($row['link']) ? $row['link'] : 'detailWisata.php?id=' . ($row['id'] ?? '');

            $three_more_cards[] = [
                'title' => !empty($row['judul']) ? $row['judul'] : 'Nama Destinasi Tambahan',
                'excerpt' => !empty($row['ringkasan']) ? substr($row['ringkasan'], 0, 80) . '...' : 'Deskripsi singkat tentang destinasi tambahan ini.',
                'image' => $image,
                'link' => $link,
                'date' => !empty($row['tanggal']) ? date('d F Y', strtotime($row['tanggal'])) : 'Belum Tersedia',
                'category' => $row['kategori'] ?? 'Kuliner'
            ];
        }
    }


    // 4. PAGINATION dan Mengambil Semua Wisata Lainnya 
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // Total data yang sudah ditampilkan sebelum bagian ini
    $initial_exclude_count = 4 + 3 + 3; // 10 data (Carousel + Pilihan 1 + Pilihan 2)

    $total_result = $conn->query("SELECT COUNT(*) AS total FROM tb_wisata");
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];

    // Hitung jumlah record yang akan dipaginasi (setelah 10 data awal)
    $paginated_records = max(0, $total_records - $initial_exclude_count);

    // Karena halaman 1 (di bagian ini) menampilkan $limit_first_page (3 data)
    // dan halaman berikutnya menampilkan $limit_per_page (3 data)

    // Hitung sisa record setelah halaman 1 (di bagian ini)
    $remaining_records_after_first_page = max(0, $paginated_records - $limit_first_page);

    // Hitung total halaman yang dibutuhkan
    $total_pages = 1; // Minimal 1 halaman (untuk $limit_first_page data)
    if ($remaining_records_after_first_page > 0) {
        $total_pages += ceil($remaining_records_after_first_page / $limit_per_page);
    }
    $total_pages = max(1, $total_pages);


    // Logika penentuan LIMIT dan OFFSET untuk query
    if ($page == 1) {
        // Halaman 1: Tampilkan $limit_first_page (3) data, dimulai dari OFFSET 10
        $limit_query = $limit_first_page;
        $db_offset = $initial_exclude_count;
    } else {
        // Halaman 2, 3, dst: Tampilkan $limit_per_page (3) data
        // OFFSET: 10 (awal) + 3 (hal 1) + ($page - 2) * 3
        $limit_query = $limit_per_page;
        $db_offset = $initial_exclude_count + $limit_first_page + (($page - 2) * $limit_per_page);
    }

    if ($db_offset < $total_records) {
        $all_wisata_query = "SELECT * FROM tb_wisata 
                             ORDER BY tanggal DESC 
                             LIMIT $limit_query OFFSET $db_offset";

        $all_wisata_result = $conn->query($all_wisata_query);

        if ($all_wisata_result) {
            while ($row = $all_wisata_result->fetch_assoc()) {
                // *** JALUR GAMBAR SUDAH BENAR ***
                $image = !empty($row['gambar']) ? "../uploads/wisata/" . $row['gambar'] : "https://placehold.co/400x300/6A8FD1/ffffff?text=Objek+Wisata+Lainnya+Gambar";

                $link = !empty($row['link']) ? $row['link'] : 'detailWisata.php?id=' . ($row['id'] ?? '');

                $all_wisata[] = [
                    'title' => !empty($row['judul']) ? $row['judul'] : 'Judul Objek Wisata',
                    'excerpt' => !empty($row['ringkasan']) ? substr($row['ringkasan'], 0, 80) . '...' : 'Ringkasan singkat tentang objek wisata ini.',
                    'image' => $image,
                    'link' => $link,
                    'date' => !empty($row['tanggal']) ? date('d F Y', strtotime($row['tanggal'])) : 'Belum Tersedia',
                    'category' => $row['kategori'] ?? 'Petualangan'
                ];
            }
        }
    }
} else {
    // Logika fallback jika koneksi DB gagal
    error_log('Database connection error in wisata.php');
    $carousel_items[] = ['title' => 'Sample (DB Gagal)', 'excerpt' => 'Pastikan koneksi database Anda benar.', 'image' => "https://placehold.co/1200x500/FF0000/ffffff?text=ERROR:+KONEKSI+DB+GAGAL", 'link' => '#', 'date' => '01 Januari 2023', 'category' => 'Error'];
    for ($i = 0; $i < 3; $i++) {
        $three_cards[] = ['title' => 'Pilihan 1-' . ($i + 1), 'excerpt' => 'Contoh deskripsi.', 'image' => "https://placehold.co/400x300/F4D03F/333333?text=Placeholder+Pilihan", 'link' => '#', 'date' => '02 Januari 2023', 'category' => 'Contoh'];
    }
    for ($i = 0; $i < 3; $i++) {
        $three_more_cards[] = ['title' => 'Pilihan 2-' . ($i + 1), 'excerpt' => 'Contoh deskripsi.', 'image' => "https://placehold.co/400x300/F4D03F/333333?text=Placeholder+Tambahan", 'link' => '#', 'date' => '02 Januari 2023', 'category' => 'Contoh'];
    }
    // HANYA 3 data untuk halaman 1 di bagian ini
    for ($i = 0; $i < 3; $i++) {
        $all_wisata[] = ['title' => 'Objek ' . ($i + 1), 'excerpt' => 'Ini adalah ringkasan.', 'image' => "https://placehold.co/400x300/6A8FD1/ffffff?text=Placeholder+Lainnya", 'link' => '#', 'date' => '03 Januari 2023', 'category' => 'Contoh'];
    }
    $total_pages = 3;
    $page = 1;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objek Wisata Desa Teniga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/CSS/wisata.css">
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
                <a href="../Halaman/berita.php" class="nav-link text-decoration-none px-3"><span class="nav-text">KABAR DESA</span></a>
                <a href="../Halaman/pelayanan.php" class="nav-link text-decoration-none px-3"><span class="nav-text">PELAYANAN</span></a>

                <div class="dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="profilDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text me-1">PROFIL DESA</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="profilDropdown">
                        <li><a class="dropdown-item" href="../Halaman/profil/lembaga.php">Lembaga Desa</a></li>
                        <li><a class="dropdown-item" href="../Halaman/profil/sejarahDesa.php">Sejarah Desa</a></li>
                        <li><a class="dropdown-item" href="../Halaman/profil/Demografi.php">Demografi Desa</a></li>
                    </ul>
                </div>

                <div class="dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="petaDropdown" aria-expanded="false">
                        <span class="nav-text me-1">PETA INTERAKTIF</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="petaDropdown">
                        <li><a class="dropdown-item" href="../Halaman/peta/petaDesa.php">Peta Desa (Umum)</a></li>
                    </ul>
                </div>

                <a href="../Halaman/wisata.php" class="nav-link text-black active text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
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
            <a href="../Halaman/berita.php" class="nav-link text-decoration-none px-3"><span class="nav-text">KABAR DESA</span></a>
            <a href="../Halaman/pelayanan.php" class="nav-link text-decoration-none px-3"><span class="nav-text">PELAYANAN</span></a>

            <div class="dropdown nav-dropdown">
                <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="profilDropdown" aria-expanded="false">
                    <span class="nav-text me-1">PROFIL DESA</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="profilDropdown">
                    <li><a class="dropdown-item" href="../Halaman/profil/lembaga.php">Lembaga Desa</a></li>
                    <li><a class="dropdown-item" href="../Halaman/profil/sejarahDesa.php">Sejarah Desa</a></li>
                    <li><a class="dropdown-item" href="../Halaman/profil/Demografi.php">Demografi Desa</a></li>
                </ul>
            </div>

            <div class="dropdown nav-dropdown">
                <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="petaDropdown" aria-expanded="false">
                    <span class="nav-text me-1">PETA INTERAKTIF</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="petaDropdown">
                    <li><a class="dropdown-item" href="../Halaman/peta/petaDesa.php">Peta Desa (Umum)</a></li>
                </ul>
            </div>

            <a href="../Halaman/wisata.php" class="nav-link text-black active text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
            <a href="../Halaman/umkmDesa.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
        </div>
    </header>

    <section class="pt-5 pb-4 bg-white">
        <div class="container text-center">
            <h2 class="display-6 fw-bold font-poppins text-dark-blue mb-2">Destinasi Wisata Desa Teniga</h2>
            <p class="fs-5 text-muted">Jelajahi keindahan dan pesona alam yang ada di Desa Teniga</p>
            <hr class="w-25 mx-auto">
        </div>
    </section>

    <section class="pb-5 bg-white">
        <div class="container">
            <?php if (!empty($carousel_items)): ?>
                <div id="wisataCarousel" class="carousel slide elegant-carousel" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php for ($i = 0; $i < count($carousel_items); $i++): ?>
                            <button type="button" data-bs-target="#wisataCarousel" data-bs-slide-to="<?php echo $i; ?>" class="<?php echo $i === 0 ? 'active' : ''; ?>" aria-current="<?php echo $i === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $i + 1; ?>"></button>
                        <?php endfor; ?>
                    </div>

                    <div class="carousel-inner rounded-2 overflow-hidden shadow-lg">
                        <?php foreach ($carousel_items as $index => $item): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <a href="<?php echo htmlspecialchars($item['link']); ?>" class="text-decoration-none text-dark d-block">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" class="d-block w-100 carousel-img" alt="<?php echo htmlspecialchars($item['title']); ?>">
                                    <div class="carousel-caption-static text-start p-4 rounded-bottom">
                                        <span class="badge mb-1 fw-medium" style="background-color: #f4d03f !important; color: #333;"><?php echo htmlspecialchars($item['category']); ?></span>
                                        <h4 class="fw-bold mb-1 line-clamp-2"><?php echo htmlspecialchars($item['title']); ?></h4>
                                        <p class="small mb-0 line-clamp-1 d-none d-sm-block"><?php echo htmlspecialchars($item['excerpt']); ?></p>
                                        <p class="small text-muted mb-0 mt-1"><i data-lucide="calendar" style="width:14px;height:14px;"></i> <?php echo htmlspecialchars($item['date']); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#wisataCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#wisataCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center shadow-sm">
                    Tidak ada objek wisata unggulan yang tersedia.
                    <img src="https://placehold.co/1200x450/A0D1F3/ffffff?text=Contoh+Wisata+Unggulan+(CAROUSEL)" class="img-fluid mt-3 rounded" alt="Placeholder Wisata Unggulan">
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php if (!empty($three_cards)): ?>
        <section class="py-5 bg-light-gray">
            <div class="container">
                <h3 class="fw-bold text-center mb-5 text-dark-blue">Wisata Pilihan Lainnya</h3>
                <div class="row g-4 mb-4">
                    <?php foreach ($three_cards as $card): ?>
                        <div class="col-12 col-md-4">
                            <a href="<?php echo htmlspecialchars($card['link']); ?>" class="card h-100 shadow-sm custom-card text-decoration-none text-dark border-0">
                                <img src="<?php echo htmlspecialchars($card['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($card['title']); ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body p-4 d-flex flex-column">
                                    <span class="badge text-bg-warning mb-2 align-self-start small">
                                        <?php echo htmlspecialchars($card['category']); ?>
                                    </span>
                                    <h5 class="card-title fw-bold mb-2 line-clamp-2">
                                        <?php echo htmlspecialchars($card['title']); ?>
                                    </h5>
                                    <p class="card-text text-secondary flex-grow-1 small line-clamp-3">
                                        <?php echo htmlspecialchars($card['excerpt']); ?>
                                    </p>
                                    <span class="mt-auto text-primary small fw-semibold">
                                        Baca Selengkapnya
                                        <i data-lucide="arrow-right" class="ms-1" style="width:14px;height:14px;"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($three_more_cards)): ?>
        <section class="py-5">
            <div class="container">
                <h3 class="fw-bold text-center mb-5 text-dark-blue">Rekomendasi Tambahan</h3>
                <div class="row g-4 mb-4">
                    <?php foreach ($three_more_cards as $card): ?>
                        <div class="col-12 col-md-4">
                            <a href="<?php echo htmlspecialchars($card['link']); ?>" class="card h-100 shadow-sm custom-card text-decoration-none text-dark border-0">
                                <img src="<?php echo htmlspecialchars($card['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($card['title']); ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body p-4 d-flex flex-column">
                                    <span class="badge text-bg-success mb-2 align-self-start small">
                                        <?php echo htmlspecialchars($card['category']); ?>
                                    </span>
                                    <h5 class="card-title fw-bold mb-2 line-clamp-2">
                                        <?php echo htmlspecialchars($card['title']); ?>
                                    </h5>
                                    <p class="card-text text-secondary flex-grow-1 small line-clamp-3">
                                        <?php echo htmlspecialchars($card['excerpt']); ?>
                                    </p>
                                    <span class="mt-auto text-primary small fw-semibold">
                                        Baca Selengkapnya
                                        <i data-lucide="arrow-right" class="ms-1" style="width:14px;height:14px;"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section>
        <div class="container">
            <?php if (!empty($all_wisata)): ?>
                <div class="row g-4 mb-4">
                    <?php foreach ($all_wisata as $wisata): ?>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <a href="<?php echo htmlspecialchars($wisata['link']); ?>"
                                class="card h-100 shadow-sm custom-card text-decoration-none text-dark border-0">
                                <img src="<?php echo htmlspecialchars($wisata['image']); ?>"
                                    class="card-img-top"
                                    alt="<?php echo htmlspecialchars($wisata['title']); ?>"
                                    style="height: 250px; object-fit: cover;">
                                <div class="card-body p-4 d-flex flex-column">
                                    <span class="badge text-bg-info mb-2 align-self-start small">
                                        <?php echo htmlspecialchars($wisata['category']); ?>
                                    </span>
                                    <h5 class="card-title fw-bold mb-2 line-clamp-2">
                                        <?php echo htmlspecialchars($wisata['title']); ?>
                                    </h5>
                                    <p class="text-muted small mb-3">
                                        <i data-lucide="calendar" style="width:14px;height:14px;"></i>
                                        <?php echo htmlspecialchars($wisata['date']); ?>
                                    </p>
                                    <p class="card-text text-secondary flex-grow-1 line-clamp-3">
                                        <?php echo htmlspecialchars($wisata['excerpt']); ?>
                                    </p>
                                    <span class="mt-auto text-primary small fw-semibold">
                                        Baca Selengkapnya
                                        <i data-lucide="arrow-right" class="ms-1" style="width:14px;height:14px;"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php else: ?>
            <?php endif; ?>
        </div>
    </section>

    <footer class="text-white text-center py-4">
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