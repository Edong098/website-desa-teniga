<?php
include "../database/dbConnect.php";
$conn = isset($konek) ? $konek : null;

$all_services = [];
$table_name = "tb_pelayanan";
$id_column = 'id_pelayanan';
$link_base = 'detailPelayanan.php?id=';

$limit = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page);

// Menggunakan tanggal aktual jika ada, atau informasi default
$default_date_info = 'Tersedia Setiap Saat';


if ($conn) {
    // Menghitung total data
    $total_result = $conn->query("SELECT COUNT(*) AS total FROM $table_name WHERE status = 'Aktif'");
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];

    $total_pages = ceil($total_records / $limit);
    $total_pages = max(1, $total_pages);

    $offset = ($page - 1) * $limit;

    // Ambil Semua Data Pelayanan (Diurutkan berdasarkan ID terbaru, seperti berita)
    $all_services_query = "SELECT * FROM $table_name 
                            WHERE status = 'Aktif'
                            ORDER BY $id_column DESC 
                            LIMIT $limit OFFSET $offset";

    $all_services_result = $conn->query($all_services_query);

    if ($all_services_result) {
        while ($row = $all_services_result->fetch_assoc()) {
            $image = !empty($row['gambar'])
                ? "../uploads/pelayanan/" . $row['gambar']
                : "https://placehold.co/400x300/185adb/ffffff?text=Layanan"; // Mengganti placeholder
            $link = $link_base . ($row[$id_column] ?? '');

            // Mengambil tanggal pembuatan/pembaruan jika ada kolom di DB
            $date_info = isset($row['tgl_dibuat']) ? date('d M Y', strtotime($row['tgl_dibuat'])) : $default_date_info;

            $all_services[] = [
                'title' => !empty($row['nama_pelayanan']) ? $row['nama_pelayanan'] : 'Layanan Desa',
                'excerpt' => !empty($row['deskripsi']) ? substr(strip_tags($row['deskripsi']), 0, 120) . '...' : 'Ringkasan singkat prosedur dan persyaratan pelayanan ini. Klik untuk detail.',
                'image' => $image,
                'link' => $link,
                'date' => $date_info,
                'category' => strtoupper($row['status'] ?? 'Aktif')
            ];
        }
    }
} else {
    error_log('Database connection error in pelayanan.php');

    // Data dummy jika koneksi gagal
    for ($i = 0; $i < $limit; $i++) {
        $all_services[] = [
            'title' => 'Layanan Darurat Kependudukan Dummy ' . ($i + 1),
            'excerpt' => 'Deskripsi singkat layanan dummy. Ini adalah ringkasan yang lebih panjang untuk simulasi kartu berita.',
            'image' => "https://placehold.co/400x300/4a86e8/ffffff?text=Pelayanan+Dummy",
            'link' => '#',
            'date' => '01 Januari 2025',
            'category' => 'DUMMY'
        ];
    }
    $total_pages = 2;
    $page = 1;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelayanan Desa Teniga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/CSS/pelayanan.css">
</head>

<body class="bg-light">
    <!-- HERO HEADER START -->
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
                <!-- jadi satu -->
                <button id="mobile-menu-btn" class="d-lg-none text-black border-0 bg-transparent me-3 me-md-0" aria-label="Toggle menu">
                    <i data-lucide="menu" style="width:28px;height:28px"></i>
                </button>
            </div>

            <nav id="main-navigation" class="d-none d-lg-flex justify-content-center text-black small fw-bold mt-4 py-1">
                <a href="../Halaman/Beranda.php" class="nav-link text-decoration-none px-3"><span class="nav-text">BERANDA</span></a>
                <a href="../Halaman/berita.php" class="nav-link text-decoration-none px-3"><span class="nav-text">KABAR DESA</span></a>
                <a href="../Halaman/pelayanan.php" class="nav-link active text-decoration-none px-3"><span class="nav-text">PELAYANAN</span></a>

                <!-- PROFIL DESA -->
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

                <!-- PETA INTERAKTIF -->
                <div class="dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="petaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text me-1">PETA INTERAKTIF</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="petaDropdown">
                        <li><a class="dropdown-item" href="../Halaman/peta/petaDesa.php">Peta Desa (Umum)</a></li>
                    </ul>
                </div>

                <!-- Objek wisata -->
                <a href="../Halaman/wisata.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
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
            <a href="../Halaman/berita.php" class="nav-link text-decoration-none px-3"><span class="nav-text">KABAR DESA</span></a>
            <a href="../Halaman/pelayanan.php" class="nav-link active text-decoration-none px-3"><span class="nav-text">PELAYANAN</span></a>

            <!-- PROFIL DESA -->
            <div class="dropdown nav-dropdown w-100">
                <a class="nav-link dropdown-toggle text-black text-decoration-none px-3 w-100" href="#" id="profilDropdownMobile" aria-expanded="false">
                    <span class="nav-text me-1">PROFIL DESA</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="profilDropdownMobile">
                    <li><a class="dropdown-item" href="../Halaman/profil/lembaga.php">Lembaga Desa</a></li>
                    <li><a class="dropdown-item" href="../Halaman/profil/sejarahDesa.php">Sejarah Desa</a></li>
                    <li><a class="dropdown-item" href="../Halaman/profil/Demografi.php">Demografi Desa</a></li>
                </ul>
            </div>

            <!-- PETA INTERAKTIF -->
            <div class="dropdown nav-dropdown w-100">
                <a class="nav-link dropdown-toggle text-black text-decoration-none px-3 w-100" href="#" id="petaDropdownMobile" aria-expanded="false">
                    <span class="nav-text me-1">PETA INTERAKTIF</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="petaDropdownMobile">
                    <li><a class="dropdown-item" href="../Halaman/peta/petaDesa.php">Peta Desa (Umum)</a></li>
                    <li><a class="dropdown-item" href="#">Peta UMKM</a></li>
                </ul>
            </div>

            <!-- Objek wisata -->
            <a href="../Halaman/wisata.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
            <!-- umkm desa -->
            <a href="../Halaman/umkmDesa.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
        </div>
    </header>

    <!-- PAGE TITLE SECTION -->
    <section class="page-title-section pt-5 pb-4 bg-white shadow-sm">
        <div class="container text-center">
            <h1 class="display-6 fw-bold font-poppins text-dark-blue mb-2">DAFTAR PELAYANAN DESA</h1>
            <p class="fs-5 text-muted">Telusuri semua informasi dan prosedur pelayanan administrasi yang tersedia di kantor desa.</p>
            <hr class="w-25 mx-auto">
        </div>
    </section>

    <!-- CONTENT CARDS SECTION -->
    <section class="py-5 bg-light">
        <div class="container">
            <?php if (!empty($all_services)): ?>
                <div class="row g-4 justify-content-center">
                    <?php foreach ($all_services as $card): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                            <a href="<?php echo htmlspecialchars($card['link']); ?>"
                                class="card h-100 shadow-sm service-card news-card text-decoration-none text-dark">
                                <!-- Card Image -->
                                <div class="card-img-top-container">
                                    <img src="<?php echo htmlspecialchars($card['image']); ?>"
                                        class="card-img-top rounded-top"
                                        alt="<?php echo htmlspecialchars($card['title']); ?>"
                                        onerror="this.onerror=null; this.src='https://placehold.co/400x300/185adb/ffffff?text=Layanan';">
                                </div>
                                <div class="card-body d-flex flex-column p-4">
                                    <!-- Meta Info -->
                                    <div class="d-flex align-items-center mb-3 justify-content-between">
                                        <span class="badge rounded-pill bg-primary fw-semibold service-category">
                                            <?php echo htmlspecialchars($card['category']); ?>
                                        </span>
                                        <span class="text-muted small service-date">
                                            <i data-lucide="calendar" class="me-1" style="width:14px;height:14px; vertical-align: middle;"></i>
                                            <?php echo htmlspecialchars($card['date']); ?>
                                        </span>
                                    </div>

                                    <!-- Title and Excerpt -->
                                    <h5 class="card-title fw-bold mb-2 line-clamp-2">
                                        <?php echo htmlspecialchars($card['title']); ?>
                                    </h5>
                                    <p class="card-text text-secondary small flex-grow-1 line-clamp-3">
                                        <?php echo htmlspecialchars($card['excerpt']); ?>
                                    </p>

                                    <!-- Read More Link -->
                                    <span class="mt-3 text-primary small fw-semibold read-more-link">
                                        Lihat Prosedur Lengkap
                                        <i data-lucide="arrow-right" class="ms-1" style="width:14px;height:14px; vertical-align: middle;"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- PAGINATION -->
                <div class="mt-5">
                    <?php if ($total_pages > 1): ?>
                        <nav aria-label="Page navigation" class="modern-pagination">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                        <i data-lucide="chevron-left" style="width:18px;height:18px;"></i>
                                    </a>
                                </li>

                                <?php
                                $start_page = max(1, $page - 2);
                                $end_page = min($total_pages, $page + 2);

                                if ($start_page > 1) {
                                    echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                                    if ($start_page > 2) {
                                        echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                                    }
                                }

                                for ($i = $start_page; $i <= $end_page; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor;

                                if ($end_page < $total_pages) {
                                    if ($end_page < $total_pages - 1) {
                                        echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                                    }
                                    echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '">' . $total_pages . '</a></li>';
                                }
                                ?>

                                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                        <i data-lucide="chevron-right" style="width:18px;height:18px;"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center shadow-sm p-4 rounded-3">
                    <h4 class="mb-2">Mohon Maaf</h4>
                    <p class="mb-0">Saat ini tidak ada data pelayanan yang tersedia atau sedang diperbarui.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>


    <!-- FOOTER START -->
    <footer class="text-white text-center py-4">
        <div class="container">
            <p class="small mb-0">Hak Cipta © 2025 Pemerintah Desa Teniga. Semua hak dilindungi undang-undang. | Didukung Program Kosabangsa
                <br>Universitas Bumigora | Dibuat oleh Ahmad Jul Hadi
            </p>
        </div>
    </footer>
    <!-- FOOTER END -->

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