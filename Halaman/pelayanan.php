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

$default_date_info = 'Informasi Tanggal Tidak Tersedia';


if ($conn) {
    $total_result = $conn->query("SELECT COUNT(*) AS total FROM $table_name WHERE status = 'Aktif'");
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];

    $total_pages = ceil($total_records / $limit);
    $total_pages = max(1, $total_pages);

    $offset = ($page - 1) * $limit;

    // Ambil Semua Data Pelayanan (Tanpa ORDER BY)
    $all_services_query = "SELECT * FROM $table_name 
                              WHERE status = 'Aktif'
                              LIMIT $limit OFFSET $offset";

    $all_services_result = $conn->query($all_services_query);

    if ($all_services_result) {
        while ($row = $all_services_result->fetch_assoc()) {
            $image = !empty($row['gambar'])
                ? "../assets/img/" . $row['gambar']
                : "https://placehold.co/400x300/e8c24a/ffffff?text=Placeholder";
            $link = $link_base . ($row[$id_column] ?? '');

            $all_services[] = [
                'title' => !empty($row['nama_pelayanan']) ? $row['nama_pelayanan'] : 'Layanan Desa',
                'excerpt' => !empty($row['deskripsi']) ? substr(strip_tags($row['deskripsi']), 0, 80) . '...' : 'Ringkasan singkat pelayanan.',
                'image' => $image,
                'link' => $link,
                'date' => $default_date_info,
                'category' => strtoupper($row['status'] ?? 'Aktif')
            ];
        }
    }
} else {
    error_log('Database connection error in pelayanan.php');

    // Data dummy jika koneksi gagal
    for ($i = 0; $i < $limit; $i++) {
        $all_services[] = [
            'title' => 'Layanan Dummy ' . ($i + 1),
            'excerpt' => 'Deskripsi singkat layanan dummy.',
            'image' => "https://placehold.co/400x300/4a86e8/ffffff?text=Placeholder+Layanan",
            'link' => '#',
            'date' => $default_date_info,
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
    <header class="hero-background position-relative">
        <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>

        <div class="container position-relative py-3" style="z-index: 20;">

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

                <button id="mobile-menu-btn" class="d-lg-none text-white border-0 bg-transparent me-3 me-md-0" aria-label="Toggle menu">
                    <i data-lucide="menu" style="width:28px;height:28px"></i>
                </button>
            </div>

            <nav id="main-navigation" class="d-none d-lg-flex justify-content-center text-black small fw-bold mt-4 py-1">
                <a href="../Halaman/Beranda.php" class="nav-link text-decoration-none px-3"><span class="nav-text">BERANDA</span></a>
                <a href="../Halaman/berita.php" class="nav-link text-decoration-none px-3"><span class="nav-text">KABAR DESA</span></a>
                <a href="../Halaman/wisata.php" class="nav-link text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
                <a href="../Halaman/pelayanan.php" class="nav-link text-decoration-none px-3"><span class="nav-text">PELAYANAN</span></a>
                <a href="../Halaman/sejarahDesa.php" class="nav-link text-decoration-none px-3"><span class="nav-text">SEJARAH</span></a>

                <div class="dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="profilDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text me-1">PROFIL DESA</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="profilDropdown">
                        <li><a class="dropdown-item" href="../Halaman/profil/lembaga.php">Lembaga Desa</a></li>
                        <li><a class="dropdown-item" href="../Halaman/profil/Demografi.php">Demografi</a></li>
                    </ul>
                </div>

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

    <section class="pt-5 pb-4 bg-white">
        <div class="container text-center">
            <h2 class="display-6 fw-bold font-poppins text-dark-blue mb-2">Daftar Pelayanan Administrasi Desa</h2>
            <p class="fs-5 text-muted">Telusuri semua informasi dan prosedur pelayanan yang tersedia di kantor desa.</p>
            <hr class="w-25 mx-auto">
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <h3 class="fw-bold text-center mb-5 d-none">Semua Daftar Pelayanan</h3>

            <?php if (!empty($all_services)): ?>
                <div class="row g-4 justify-content-center">
                    <?php foreach ($all_services as $card): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                            <a href="<?php echo htmlspecialchars($card['link']); ?>"
                                class="card h-100 shadow service-card text-decoration-none text-dark">
                                <img src="<?php echo htmlspecialchars($card['image']); ?>"
                                    class="card-img-top rounded-top"
                                    alt="<?php echo htmlspecialchars($card['title']); ?>">
                                <div class="card-body d-flex flex-column p-4">
                                    <span class="badge rounded-pill bg-primary mb-2 fw-medium"
                                        style="width: fit-content;">
                                        <?php echo htmlspecialchars($card['category']); ?>
                                    </span>
                                    <h5 class="card-title fw-bold mb-2 line-clamp-2">
                                        <?php echo htmlspecialchars($card['title']); ?>
                                    </h5>
                                    <p class="card-text text-secondary small flex-grow-1 line-clamp-3">
                                        <?php echo htmlspecialchars($card['excerpt']); ?>
                                    </p>
                                    <p class="text-muted small mb-0 mt-2">
                                        <i data-lucide="calendar" style="width:14px;height:14px;"></i>
                                        <?php echo htmlspecialchars($card['date']); ?>
                                    </p>
                                    <span class="mt-2 text-primary small fw-semibold">
                                        Lihat Prosedur
                                        <i data-lucide="arrow-right" class="ms-1" style="width:14px;height:14px;"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

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
                                // Tampilkan halaman di sekitar halaman saat ini
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
                <div class="alert alert-info text-center shadow-sm">
                    Tidak ada data pelayanan yang tersedia.
                </div>
            <?php endif; ?>
        </div>
    </section>


    <footer class="text-white text-center py-4">
        <div class="container">
            <p class="small mb-0">
                Hak Cipta ©2025 Teniga. Universitas Bumigora | Diciptakan oleh Julbedong
            </p>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        // Logika Dropdown dan Hover (Sama)
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
    </script>
</body>

</html>