<?php
include "../../database/dbConnect.php";

$currentPage = basename($_SERVER['PHP_SELF']);

$conn = isset($konek) ? $konek : null;

$data_lembaga = [];
$table_name = "tb_lembaga_desa";

if ($conn) {
    $lembaga_query = "SELECT * FROM $table_name ORDER BY nama_lembaga ASC";

    $lembaga_result = $conn->query($lembaga_query);

    if ($lembaga_result && $lembaga_result->num_rows > 1) {
        while ($row = $lembaga_result->fetch_assoc()) {
            $image = !empty($row['gambar'])
                ? "../../uploads/demografi/" . $row['gambar']
                : "https://placehold.co/400x300/185adb/ffffff?text=Layanan";
            $link = $link_base . ($row[$id_column] ?? '');
            $data_lembaga[] = [
                'nama_lembaga' => htmlspecialchars($row['nama_lembaga'] ?? 'N/A'),
                'ketua' => htmlspecialchars($row['ketua'] ?? 'N/A'),
                'jumlah_anggota' => number_format($row['jumlah_anggota'] ?? 0, 0, ',', '.'),
                'deskripsi' => nl2br(htmlspecialchars($row['deskripsi'] ?? 'Deskripsi belum tersedia.')),
                'gambar' => $image,
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
                style="margin-left: 10.5%; transform: translateY(8px); margin-bottom: -9px;">
                <a href="../../Halaman/Beranda.php" class="d-flex align-items-center text-black text-decoration-none ms-3 ms-md-0">
                    <img src="../../assets/img/CDR_LOGO_DESA.png"
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

            <!-- Baris Navigasi -->
            <nav id="main-navigation" class="d-none d-lg-flex justify-content-center text-black small fw-bold mt-4 py-1">
                <a href="../../Halaman/Beranda.php" class="nav-link text-decoration-none px-3"><span class="nav-text">BERANDA</span></a>
                <a href="../../Halaman/berita.php" class="nav-link text-decoration-none px-3"><span class="nav-text">KABAR DESA</span></a>
                <a href="../../Halaman/pelayanan.php" class="nav-link text-decoration-none px-3"><span class="nav-text">PELAYANAN</span></a>

                <!-- PROFIL DESA -->
                <div class="dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle text-black active text-decoration-none px-3" href="#" id="profilDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text me-1">PROFIL DESA</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="profilDropdown">
                        <li>
                            <a class="dropdown-item <?= ($currentPage == 'lembaga.php') ? 'active disabled text-secondary' : '' ?>"
                                href="<?= ($currentPage != 'sejarahDesa.php') ? '../../Halaman/profil/lembaga.php' : '#' ?>">
                                Lembaga Desa
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="../../Halaman/profil/sejarahDesa.php">Sejarah Desa</a></li>
                        <li><a class="dropdown-item" href="../../Halaman/profil/Demografi.php">Demografi Desa</a></li>
                    </ul>
                </div>

                <!-- PETA INTERAKTIF -->
                <div class="dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="petaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text me-1">PETA INTERAKTIF</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="petaDropdown">
                        <li><a class="dropdown-item" href="../../Halaman/peta/petaDesa.php">Peta Desa (Umum)</a></li>
                    </ul>
                </div>

                <!-- Objek wisata -->
                <a href="../../Halaman/wisata.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
                <!-- umkm desa -->
                <a href="../../Halaman/umkmDesa.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
            </nav>
        </div>

        <div class="mobile-menu" id="mobile-menu">
            <div class="mobile-menu-header">
                <h5 class="fw-bold mb-0">Menu Navigasi</h5>
                <button id="close-menu-btn" class="border-0 bg-transparent" aria-label="Close menu">
                    <i data-lucide="x" style="width:24px;height:24px; color: #333;"></i>
                </button>
            </div>

            <a href="../../Halaman/Beranda.php" class="nav-link text-decoration-none px-3"><span class="nav-text">BERANDA</span></a>
            <a href="../../Halaman/berita.php" class="nav-link text-decoration-none px-3"><span class="nav-text">KABAR DESA</span></a>
            <a href="../../Halaman/pelayanan.php" class="nav-link text-decoration-none px-3"><span class="nav-text">PELAYANAN</span></a>

            <!-- PROFIL DESA -->
            <div class="dropdown nav-dropdown">
                <a class="nav-link dropdown-toggle text-black active text-decoration-none px-3" href="#" id="profilDropdown" aria-expanded="false">
                    <span class="nav-text me-1">PROFIL DESA</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="profilDropdown">
                    <li>
                        <a class="dropdown-item <?= ($currentPage == 'lembaga.php') ? 'active disabled text-secondary' : '' ?>"
                            href="<?= ($currentPage != 'sejarahDesa.php') ? '../../Halaman/profil/lembaga.php' : '#' ?>">
                            Lembaga Desa
                        </a>
                    </li>
                    <li><a class="dropdown-item" href="../../Halaman/profil/sejarahDesa.php">Sejarah Desa</a></li>
                    <li><a class="dropdown-item" href="../../Halaman/profil/Demografi.php">Demografi Desa</a></li>
                </ul>
            </div>

            <!-- PETA INTERAKTIF -->
            <div class="dropdown nav-dropdown">
                <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="petaDropdown" aria-expanded="false">
                    <span class="nav-text me-1">PETA INTERAKTIF</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="petaDropdown">
                    <li><a class="dropdown-item" href="../../Halaman/peta/petaDesa.php">Peta Desa (Umum)</a></li>
                </ul>
            </div>

            <!-- Objek wisata -->
            <a href="../../Halaman/wisata.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
            <!-- umkm desa -->
            <a href="../../Halaman/umkmDesa.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
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
                <div class="row g-3">

                    <?php
                    // Inisialisasi penghitung
                    $counter = 0;
                    // Tentukan batas maksimal card yang akan ditampilkan
                    $max_cards = 3;
                    ?>

                    <?php foreach ($data_lembaga as $lembaga): ?>
                        <?php
                        // Periksa apakah batas sudah tercapai
                        if ($counter >= $max_cards) {
                            break; // Keluar dari loop jika 3 card sudah ditampilkan
                        }
                        ?>
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
                                        <li class="d-flex justify-content-left">
                                            <div class="text-start me-3 d-inline-flex align-items-center">
                                                <i data-lucide="user" class="info-icon me-2"></i>Ketua:
                                            </div>
                                            <span class="fw-semibold text-start-left text-break ms-auto"><?php echo $lembaga['ketua']; ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <div class="text-start me-3 d-inline-flex align-items-center">
                                                <i data-lucide="users" class="info-icon me-2"></i>Jumlah Anggota:
                                            </div>
                                            <span class="fw-semibold text-start text-break ms-auto"><?php echo $lembaga['jumlah_anggota']; ?> orang</span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <div class="text-start me-3 d-inline-flex align-items-center">
                                                <i data-lucide="map-pin" class="info-icon me-2"></i>Alamat:
                                            </div>
                                            <span class="fw-semibold text-start text-break ms-auto"><?php echo $lembaga['alamat']; ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <div class="text-start me-3 d-inline-flex align-items-center">
                                                <i data-lucide="phone" class="info-icon me-2"></i>Kontak:
                                            </div>
                                            <span class="fw-semibold text-start text-break ms-auto"><?php echo $lembaga['kontak']; ?></span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-footer">
                                    Diunggah oleh: <?php echo $lembaga['penulis']; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        // Tingkatkan nilai penghitung setelah satu card ditampilkan
                        $counter++;
                        ?>
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