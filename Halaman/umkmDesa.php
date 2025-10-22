<?php
include "../database/dbConnect.php";

$conn = $konek;
$all_umkm = [];
$table_name = "tb_umkm";
$id_column = 'id_umkm';
$link_base = 'detailUmkm.php?id=';
$limit = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page);

if ($conn) {
    $count_query = "SELECT COUNT(*) AS total FROM $table_name";
    $total_result = $conn->query($count_query);
    $total_records = $total_result ? $total_result->fetch_assoc()['total'] : 0;
    $total_pages = ceil($total_records / $limit);
    $total_pages = max(1, $total_pages);
    $offset = ($page - 1) * $limit;

    $data_query = "SELECT * FROM $table_name LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($data_query);

    if ($stmt) {
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $all_umkm_result = $stmt->get_result();

        if ($all_umkm_result) {
            while ($row = $all_umkm_result->fetch_assoc()) {

                $image_path = htmlspecialchars($row['gambar_produk'] ?? '');
                $image = !empty($image_path)
                    ? "../assets/img/" . $image_path
                    : "https://placehold.co/800x400/a2d2ff/000000?text=Produk+UMKM+Lebar";

                $harga_produk = $row['harga_produk'] ?? 0;
                $harga_display = 'Rp ' . number_format($harga_produk, 0, ',', '.');

                $kontak_clean = preg_replace('/[^0-9]/', '', $row['kontak_umkm'] ?? '');
                if (!empty($kontak_clean) && substr($kontak_clean, 0, 1) === '0') {
                    $kontak_clean = '62' . substr($kontak_clean, 1);
                }

                $message = "Halo, saya tertarik dengan produk *{$row['produk']}* dari *{$row['nama_umkm']}* yang ada di website desa. Apakah produk ini masih tersedia?";
                $kontak_link = "https://wa.me/" . $kontak_clean . "?text=" . urlencode($message);

                $all_umkm[] = [
                    'nama_umkm' => htmlspecialchars($row['nama_umkm'] ?? 'Nama UMKM'),
                    'produk' => htmlspecialchars($row['produk'] ?? 'Produk Unggulan'),
                    'harga' => $harga_display,
                    'kontak' => htmlspecialchars($row['kontak_umkm'] ?? 'Kontak UMKM'),
                    'kontak_link' => htmlspecialchars($kontak_link),
                    'image' => $image,
                    'link' => htmlspecialchars($link_base . ($row[$id_column] ?? '')),
                    'category' => strtoupper(htmlspecialchars(explode(' ', $row['nama_umkm'])[0] ?? 'UMKM')),
                    'alamat' => htmlspecialchars($row['alamat_umkm'] ?? 'Alamat Tidak Tersedia')
                ];
            }
        }
        $stmt->close();
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


            <!-- Baris Navigasi -->
            <nav id="main-navigation" class="d-none d-lg-flex justify-content-center text-black small fw-bold mt-4 py-1">
                <a href="../Halaman/Beranda.php" class="nav-link text-decoration-none px-3"><span class="nav-text">BERANDA</span></a>
                <a href="../Halaman/berita.php" class="nav-link text-decoration-none px-3"><span class="nav-text">KABAR DESA</span></a>
                <a href="../Halaman/pelayanan.php" class="nav-link text-decoration-none px-3"><span class="nav-text">PELAYANAN</span></a>

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
                        <li><a class="dropdown-item" href="#">Peta UMKM</a></li>
                    </ul>
                </div>

                <!-- Objek wisata -->
                <a href="../Halaman/wisata.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
                <!-- umkm desa -->
                <a href="../Halaman/umkmDesa.php" class="nav-link text-black active text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
            </nav>
        </div>
    </header>

    <section class="pt-5 pb-4 bg-white">
        <div class="container text-center">
            <h2 class="display-6 fw-bold font-poppins text-dark-blue mb-2">Daftar Produk UMKM Desa</h2>
            <p class="fs-5 text-muted">Dukung ekonomi lokal! Temukan berbagai produk unggulan dari UMKM di desa kami.</p>
            <hr class="w-25 mx-auto">
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">
            <?php if (!empty($all_umkm)): ?>
                <div class="row g-4 justify-content-center">
                    <?php foreach ($all_umkm as $card): ?>
                        <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">
                            <div class="card shadow umkm-card text-dark new-design w-100">
                                <div class="card-image-wrapper position-relative">
                                    <img src="<?php echo $card['image']; ?>"
                                        class="card-img-top rounded-top"
                                        alt="<?php echo $card['produk']; ?>">

                                    <div class="card-overlay-text p-3">
                                        <span class="badge rounded-pill umkm-badge mb-2 fw-medium">
                                            <?php echo $card['category']; ?>
                                        </span>

                                        <h5 class="card-title-overlay fw-bold mb-1 line-clamp-2 text-white">
                                            <?php
                                            $produk_text = $card['produk'];
                                            if (strlen($produk_text) < 25) {
                                                $produk_text = $produk_text . "<br>" . "&nbsp;";
                                            }
                                            echo $produk_text;
                                            ?>
                                        </h5>
                                    </div>
                                </div>

                                <div class="card-body d-flex flex-column p-4">

                                    <!-- 🔹 Tambahkan Nama UMKM di atas harga -->
                                    <h5 class="card-title mb-2 fw-bold text-primary">
                                        <?php echo $card['nama_umkm']; ?>
                                    </h5>

                                    <!-- 🔹 Harga Produk -->
                                    <h6 class="card-subtitle mb-3 fw-semibold text-dark">
                                        <?php echo $card['harga']; ?>
                                    </h6>

                                    <div class="card-text text-secondary small flex-grow-1 mb-3">
                                        <div class="d-flex align-items-start mb-1">
                                            <i data-lucide="building" style="width:18px;height:18px; margin-top: 3px;"></i>
                                            <span class="ms-2 fw-semibold line-clamp-1">
                                                <?php echo $card['nama_umkm']; ?>
                                            </span>
                                        </div>

                                        <div class="d-flex align-items-start">
                                            <i data-lucide="map-pin" style="width:18px;height:18px; margin-top: 3px;"></i>
                                            <span class="ms-2 text-wrap line-clamp-2">
                                                <?php
                                                $alamat_text = $card['alamat'];
                                                if (strlen($alamat_text) < 20) {
                                                    $alamat_text = $alamat_text . "<br>" . "&nbsp;";
                                                }
                                                echo $alamat_text;
                                                ?>
                                            </span>
                                        </div>
                                    </div>

                                    <a href="<?php echo $card['kontak_link']; ?>"
                                        target="_blank"
                                        class="mt-auto wa-button">
                                        <i data-lucide="whatsapp" class="me-1" style="width:20px;height:20px;"></i>
                                        Hubungi Sekarang
                                    </a>
                                </div>
                            </div>
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
                    Saat ini belum ada data UMKM yang tersedia.
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
                    }, );
                });
            });
        })();
    </script>
</body>

</html>