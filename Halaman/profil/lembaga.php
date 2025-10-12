<?php
include "../../database/dbConnect.php";

$conn = isset($konek) ? $konek : null;

$data_lembaga = [];
$table_name = "tb_lembaga_desa";

if ($conn) {
    $lembaga_query = "SELECT * FROM $table_name ORDER BY nama_lembaga ASC";

    $lembaga_result = $conn->query($lembaga_query);

    if ($lembaga_result && $lembaga_result->num_rows > 0) {
        while ($row = $lembaga_result->fetch_assoc()) {
            $image_path = !empty($row['gambar']) ? "../../assets/img/" . $row['gambar'] : '';
            $gambar_url = (file_exists($image_path) && !is_dir($image_path))
                ? $image_path
                : 'https://placehold.co/400x300/0c519b/ffffff?text=' . urlencode($row['nama_lembaga']);

            $data_lembaga[] = [
                'nama_lembaga' => htmlspecialchars($row['nama_lembaga'] ?? 'N/A'),
                'ketua' => htmlspecialchars($row['ketua'] ?? 'N/A'),
                'jumlah_anggota' => number_format($row['jumlah_anggota'] ?? 0, 0, ',', '.'),
                'deskripsi' => nl2br(htmlspecialchars($row['deskripsi'] ?? 'Deskripsi belum tersedia.')),
                'gambar' => $gambar_url,
                'kontak' => htmlspecialchars($row['kontak'] ?? 'N/A'),
                'alamat' => htmlspecialchars($row['alamat'] ?? 'N/A'),
                'penulis' => ucwords(htmlspecialchars($row['penulis'] ?? 'Admin')),
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
    <title>Lembaga Desa Teniga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../assets/CSS/lembaga.css">
</head>

<body class="bg-light">
    <header class="hero-background position-relative">
        <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>

        <div class="container position-relative py-3" style="z-index: 20;">
            <div class="d-flex justify-content-between align-items-center w-100 position-relative"
                style="margin-left: 12%; transform: translateY(8px); margin-bottom: -9px;">
                <a href="../../Halaman/Beranda.php" class="d-flex align-items-center text-black text-decoration-none ms-3 ms-md-0">
                    <img src="../../assets/img/CDR_LOGO_DESA.png"
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
                <a href="../../Halaman/Beranda.php" class="nav-link text-decoration-none px-3"><span class="nav-text">BERANDA</span></a>
                <a href="../../Halaman/berita.php" class="nav-link text-decoration-none px-3"><span class="nav-text">KABAR DESA</span></a>
                <a href="../../Halaman/wisata.php" class="nav-link text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
                <a href="../../Halaman/pelayanan.php" class="nav-link text-decoration-none px-3"><span class="nav-text">PELAYANAN</span></a>
                <a href="../../Halaman/sejarahDesa.php" class="nav-link text-decoration-none px-3"><span class="nav-text">SEJARAH</span></a>

                <div class="dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle text-black text-decoration-none px-3 active" href="#" id="profilDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text me-1">PROFIL DESA</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="profilDropdown">
                        <li><a class="dropdown-item" href="lembaga.php">Lembaga Desa</a></li>
                        <li><a class="dropdown-item" href="demografi.php">Demografi</a></li>
                    </ul>
                </div>

                <div class="dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="petaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text me-1">PETA INTERAKTIF</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="petaDropdown">
                        <li><a class="dropdown-item" href="../peta/petaDesa.php">Peta Desa (Umum)</a></li>
                        <li><a class="dropdown-item" href="#">Peta UMKM</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <section class="pt-5 pb-4 bg-white">
        <div class="container text-center">
            <h1 class="display-6 fw-bold font-poppins text-dark-blue mb-2">Lembaga-Lembaga Desa Teniga</h1>
            <p class="fs-5 text-muted">Struktur dan peran organisasi penggerak pembangunan desa.</p>
            <hr class="w-25 mx-auto">
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">

            <div class="organization-chart-section">
                <h2 class="h3 fw-bold text-dark-blue text-center mb-4">Bagan Kepengurusan Pemerintah Desa Teniga</h2>
                <p class="text-center text-muted mb-4">Struktur organisasi dan tata kelola pemerintahan desa.</p>

                <img src="../../assets/img/struktur_desa_teniga.jpg"
                    alt="Bagan Kepengurusan Desa Teniga"
                    title="Bagan Kepengurusan Desa Teniga"
                    class="img-fluid">

                <div class="text-center small mt-3 text-muted">
                    <i data-lucide="calendar" style="width: 14px; height: 14px; display: inline-block;"></i> Struktur kepengurusan per tahun <?php echo date('Y'); ?>
                </div>
            </div>
            <h2 class="h3 fw-bold text-dark-blue text-center mb-4 mt-5">Lembaga Kemasyarakatan Desa</h2>
            <p class="text-center text-muted mb-4">Daftar lembaga yang mendukung kegiatan pembangunan dan pemberdayaan masyarakat desa.</p>

            <?php if (!empty($data_lembaga)): ?>
                <div class="row g-4">

                    <?php foreach ($data_lembaga as $lembaga): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="lembaga-card">

                                <img src="<?php echo $lembaga['gambar']; ?>"
                                    class="card-header-image"
                                    alt="Gambar <?php echo $lembaga['nama_lembaga']; ?>">

                                <div class="card-body">
                                    <h3 class="lembaga-title"><?php echo $lembaga['nama_lembaga']; ?></h3>

                                    <p class="card-text text-muted mb-3" style="font-size: 0.9rem;">
                                        <?php echo $lembaga['deskripsi']; ?>
                                    </p>

                                    <ul class="meta-info-list">
                                        <li>
                                            <i data-lucide="user" class="info-icon"></i>
                                            **Ketua:** <span class="fw-semibold ms-auto"><?php echo $lembaga['ketua']; ?></span>
                                        </li>
                                        <li>
                                            <i data-lucide="users" class="info-icon"></i>
                                            **Jumlah Anggota:** <span class="fw-semibold ms-auto"><?php echo $lembaga['jumlah_anggota']; ?> orang</span>
                                        </li>
                                        <li>
                                            <i data-lucide="map-pin" class="info-icon"></i>
                                            **Alamat:** <span class="fw-semibold ms-auto"><?php echo $lembaga['alamat']; ?></span>
                                        </li>
                                        <li>
                                            <i data-lucide="phone" class="info-icon"></i>
                                            **Kontak:** <span class="fw-semibold ms-auto"><?php echo $lembaga['kontak']; ?></span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-footer">
                                    Diunggah oleh: **<?php echo $lembaga['penulis']; ?>**
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center" role="alert">
                    Belum ada data lembaga desa yang terdaftar saat ini.
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

        // Logika Dropdown dan Hover (Disertakan agar navigasi tetap berfungsi)
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