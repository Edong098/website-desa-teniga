<?php
include "../../database/dbConnect.php";

$conn = isset($konek) ? $konek : null;

$currentPage = basename($_SERVER['PHP_SELF']);

$data_demografi = [
    'tahun' => date('Y'),
    'jumlah_penduduk' => 0,
    'laki_laki' => 0,
    'perempuan' => 0,
    'jumlah_kk' => 0,
    'luas_wilayah' => 0.00,
    'kepadatan_penduduk' => 0.00,
    'deskripsi' => 'Data demografi terbaru belum tersedia. Mohon hubungi administrator.',
    'gambar' => '',
    'penulis' => 'Admin',
    'tanggal_post' => date('d F Y')
];

$all_demografi_history = [];
$table_name = "tb_demografi";

if ($conn) {
    // Ambil data demografi terbaru
    $demografi_latest_query = "SELECT * FROM $table_name 
                        ORDER BY tahun DESC, tanggal_post DESC 
                        LIMIT 1";

    $demografi_latest_result = $conn->query($demografi_latest_query);

    if ($demografi_latest_result && $demografi_latest_result->num_rows > 0) {
        $row = $demografi_latest_result->fetch_assoc();

        // Pengisian data untuk TAHUN TERBARU
        $data_demografi['tahun'] = $row['tahun'] ?? date('Y');
        $data_demografi['jumlah_penduduk'] = $row['jumlah_penduduk'] ?? 0;
        $data_demografi['laki_laki'] = $row['laki_laki'] ?? 0;
        $data_demografi['perempuan'] = $row['perempuan'] ?? 0;
        $data_demografi['jumlah_kk'] = $row['jumlah_kk'] ?? 0;
        $data_demografi['luas_wilayah'] = number_format($row['luas_wilayah'] ?? 0.00, 2);
        $data_demografi['kepadatan_penduduk'] = number_format($row['kepadatan_penduduk'] ?? 0.00, 2);

        $data_demografi['deskripsi'] = !empty($row['deskripsi']) ? $row['deskripsi'] : $data_demografi['deskripsi'];
        $data_demografi['penulis'] = ucwords($row['penulis'] ?? 'Admin');
        $data_demografi['tanggal_post'] = !empty($row['tanggal_post']) ? date('d F Y', strtotime($row['tanggal_post'])) : date('d F Y');
    }

    // Ambil SEMUA data demografi
    $demografi_all_query = "SELECT tahun, jumlah_penduduk, jumlah_kk, kepadatan_penduduk FROM $table_name 
                        ORDER BY tahun DESC";

    $demografi_all_result = $conn->query($demografi_all_query);

    if ($demografi_all_result) {
        while ($row_all = $demografi_all_result->fetch_assoc()) {
            $all_demografi_history[] = [
                'tahun' => $row_all['tahun'] ?? 'T/A',
                'penduduk' => number_format($row_all['jumlah_penduduk'] ?? 0, 0, ',', '.'),
                'kk' => number_format($row_all['jumlah_kk'] ?? 0, 0, ',', '.'),
                'kepadatan' => number_format($row_all['kepadatan_penduduk'] ?? 0.00, 2)
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
    <title>Demografi Desa Teniga Tahun <?php echo $data_demografi['tahun']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../assets/CSS/demografi.css">

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

                <button id="mobile-menu-btn" class="d-lg-none text-white border-0 bg-transparent me-3 me-md-0" aria-label="Toggle menu">
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
                        <li><a class="dropdown-item" href="../../Halaman/profil/lembaga.php">Lembaga Desa</a></li>
                        <li><a class="dropdown-item" href="../../Halaman/profil/sejarahDesa.php">Sejarah Desa</a></li>
                        <li>
                            <a class="dropdown-item <?= ($currentPage == 'demografi.php') ? 'active disabled text-secondary' : '' ?>"
                                href="<?= ($currentPage != 'demografi.php') ? '../../Halaman/profil/demografi.php' : '#' ?>">
                                Demografi Desa
                            </a>>
                        </li>
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
    </header>

    <section class="pt-5 pb-4 bg-white">
        <div class="container text-center">
            <h1 class="display-6 fw-bold font-poppins text-dark-blue mb-2">Demografi & Profil Desa Teniga Tahun <?php echo htmlspecialchars($data_demografi['tahun']); ?></h1>
            <p class="fs-5 text-muted">Data statistik kependudukan dan profil kondisi desa terbaru.</p>
            <hr class="w-25 mx-auto">
        </div>
    </section>

    <section class="pb-5 pt-3 bg-light">
        <div class="container">

            <h2 class="h4 fw-bold text-dark-blue mb-4 text-center">Data Kunci Kependudukan Tahun <?php echo htmlspecialchars($data_demografi['tahun']); ?></h2>

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="demografi-card">
                        <div class="card-icon" style="background-color: #28a745;">
                            <i data-lucide="users"></i>
                        </div>
                        <div class="card-value">
                            <?php echo number_format($data_demografi['jumlah_penduduk'], 0, ',', '.'); ?>
                        </div>
                        <div class="card-label">TOTAL PENDUDUK</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="demografi-card">
                        <div class="card-icon" style="background-color: #007bff;">
                            <i data-lucide="user"></i>
                        </div>
                        <div class="card-value">
                            <?php echo number_format($data_demografi['laki_laki'], 0, ',', '.'); ?>
                        </div>
                        <div class="card-label">PENDUDUK LAKI-LAKI</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="demografi-card">
                        <div class="card-icon" style="background-color: #ffc107;">
                            <i data-lucide="user-round"></i>
                        </div>
                        <div class="card-value">
                            <?php echo number_format($data_demografi['perempuan'], 0, ',', '.'); ?>
                        </div>
                        <div class="card-label">PENDUDUK PEREMPUAN</div>
                    </div>
                </div>

            </div>

            <div class="row g-4 mb-5">

                <div class="col-md-4">
                    <div class="demografi-card">
                        <div class="card-icon" style="background-color: #6c757d;">
                            <i data-lucide="home"></i>
                        </div>
                        <div class="card-value">
                            <?php echo number_format($data_demografi['jumlah_kk'], 0, ',', '.'); ?>
                        </div>
                        <div class="card-label">JUMLAH KEPALA KELUARGA (KK)</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="demografi-card">
                        <div class="card-icon" style="background-color: #17a2b8;">
                            <i data-lucide="map-pin"></i>
                        </div>
                        <div class="card-value">
                            <?php echo htmlspecialchars($data_demografi['luas_wilayah']); ?>
                            <span class="small fw-normal">km²</span>
                        </div>
                        <div class="card-label">LUAS WILAYAH</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="demografi-card">
                        <div class="card-icon" style="background-color: #dc3545;">
                            <i data-lucide="area-chart"></i>
                        </div>
                        <div class="card-value">
                            <?php echo htmlspecialchars($data_demografi['kepadatan_penduduk']); ?>
                            <span class="small fw-normal">jiwa/km²</span>
                        </div>
                        <div class="card-label">KEPADATAN PENDUDUK</div>
                    </div>
                </div>
            </div>


            <div class="row mb-5">
                <div class="col-12">
                    <div class="info-detail-section">
                        <h3 class="fw-bold text-dark-blue mb-4">Profil Kondisi Desa <?php echo htmlspecialchars($data_demografi['tahun']); ?></h3>

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="umum-tab" data-bs-toggle="tab" data-bs-target="#umum-tab-pane" type="button" role="tab" aria-controls="umum-tab-pane" aria-selected="true"><i data-lucide="info" class="me-1" style="width: 18px;"></i> Kondisi Umum</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="infrastruktur-tab" data-bs-toggle="tab" data-bs-target="#infrastruktur-tab-pane" type="button" role="tab" aria-controls="infrastruktur-tab-pane" aria-selected="false"><i data-lucide="building-2" class="me-1" style="width: 18px;"></i> Infrastruktur</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ekonomi-tab" data-bs-toggle="tab" data-bs-target="#ekonomi-tab-pane" type="button" role="tab" aria-controls="ekonomi-tab-pane" aria-selected="false"><i data-lucide="piggy-bank" class="me-1" style="width: 18px;"></i> Ekonomi & Sosial</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="umum-tab-pane" role="tabpanel" aria-labelledby="umum-tab" tabindex="0">
                                <h5 class="fw-bold text-dark-blue">Ringkasan Deskriptif Desa</h5>
                                <p class="text-muted" style="line-height: 1.8;">
                                    <?php
                                    // Menampilkan seluruh isi kolom deskripsi dari DB
                                    echo nl2br(htmlspecialchars($data_demografi['deskripsi']));
                                    ?>
                                </p>
                            </div>

                            <div class="tab-pane fade" id="infrastruktur-tab-pane" role="tabpanel" aria-labelledby="infrastruktur-tab" tabindex="0">
                                <h5 class="fw-bold text-dark-blue">Data Infrastruktur Utama Desa</h5>
                                <p class="text-muted">
                                    Informasi mengenai pembangunan jalan, irigasi, listrik, dan fasilitas umum lainnya. (Data ini perlu diisi secara manual di kolom Deskripsi, atau melalui manajemen konten jika ada).
                                    <br><br>
                                    *Saat ini, data ini masih berupa placeholder. Mohon masukkan detail infrastruktur ke dalam database atau buat kolom terpisah jika diperlukan.*
                                </p>
                            </div>

                            <div class="tab-pane fade" id="ekonomi-tab-pane" role="tabpanel" aria-labelledby="ekonomi-tab" tabindex="0">
                                <h5 class="fw-bold text-dark-blue">Sektor Ekonomi dan Kehidupan Sosial</h5>
                                <p class="text-muted">
                                    Deskripsi mengenai mata pencaharian utama (pertanian/perikanan/pariwisata), UMKM, tingkat pendidikan, dan kesehatan. (Data ini perlu diisi secara manual di kolom Deskripsi, atau melalui manajemen konten jika ada).
                                    <br><br>
                                    *Saat ini, data ini masih berupa placeholder. Mohon masukkan detail ekonomi/sosial ke dalam database atau buat kolom terpisah jika diperlukan.*
                                </p>
                            </div>

                        </div>

                        <div class="mt-4 pt-3 border-top small text-end text-muted">
                            Diperbarui oleh: **<?php echo htmlspecialchars($data_demografi['penulis']); ?>** pada **<?php echo htmlspecialchars($data_demografi['tanggal_post']); ?>**
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>

    <section class="py-1">
        <div class="container">
            <h2 class="h4 fw-bold text-dark-blue mb-4 text-center">Riwayat Data Demografi Tahunan</h2>
            <p class="text-center text-muted mb-4">Geser ke kanan untuk melihat data tahun sebelumnya.</p>

            <?php if (!empty($all_demografi_history)): ?>
                <div class="history-container">
                    <?php foreach ($all_demografi_history as $history): ?>
                        <div class="history-card-wrapper">
                            <div class="history-card">
                                <div class="card-title"><?php echo htmlspecialchars($history['tahun']); ?></div>

                                <div class="history-detail">
                                    <div class="icon-wrapper"><i data-lucide="users"></i></div>
                                    <span>Total Penduduk:</span>
                                    <span class="value"><?php echo htmlspecialchars($history['penduduk']); ?></span>
                                </div>

                                <div class="history-detail">
                                    <div class="icon-wrapper"><i data-lucide="home"></i></div>
                                    <span>Jumlah KK:</span>
                                    <span class="value"><?php echo htmlspecialchars($history['kk']); ?></span>
                                </div>

                                <div class="history-detail">
                                    <div class="icon-wrapper"><i data-lucide="area-chart"></i></div>
                                    <span>Kepadatan:</span>
                                    <span class="value"><?php echo htmlspecialchars($history['kepadatan']); ?> jiwa/km²</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center">
                    Data riwayat demografi tahunan tidak ditemukan.
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
    </script>
</body>

</html>