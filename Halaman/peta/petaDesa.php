<!-- Data tb_peta_desa belum dimasukkan -->
<?php
include "../../database/dbConnect.php";
$conn = isset($konek) ? $konek : null;

$currentPage = basename($_SERVER['PHP_SELF']);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Desa Interaktif Profesional - Desa Teniga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />
    <link rel="stylesheet" href="../../assets/CSS/petaDesa.css">
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
                    <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="profilDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text me-1">PROFIL DESA</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="profilDropdown">
                        <li><a class="dropdown-item" href="../../Halaman/profil/lembaga.php">Lembaga Desa</a></li>
                        <li><a class="dropdown-item" href="../../Halaman/profil/sejarahDesa.php">Sejarah Desa</a></li>
                        <li><a class="dropdown-item" href="../../Halaman/profil/Demografi.php">Demografi Desa</a></li>
                    </ul>
                </div>

                <!-- PETA INTERAKTIF -->
                <div class="dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle text-black active text-decoration-none px-3" href="#" id="petaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text me-1">PETA INTERAKTIF</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="petaDropdown">
                        <li>
                            <a class="dropdown-item <?= ($currentPage == 'petaDesa.php') ? 'active disabled text-secondary' : '' ?>"
                                href="<?= ($currentPage != 'petaDesa.php') ? '../../Halaman/profil/petaDesa.php' : '#' ?>">
                                Peta Desa (Umum)
                            </a>
                        </li>
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
                <a class="nav-link dropdown-toggle text-black text-decoration-none px-3" href="#" id="profilDropdown" aria-expanded="false">
                    <span class="nav-text me-1">PROFIL DESA</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="profilDropdown">
                    <li><a class="dropdown-item" href="../../Halaman/profil/lembaga.php">Lembaga Desa</a></li>
                    <li><a class="dropdown-item" href="../../Halaman/profil/sejarahDesa.php">Sejarah Desa</a></li>
                    <li><a class="dropdown-item" href="../../Halaman/profil/Demografi.php">Demografi Desa</a></li>
                </ul>
            </div>

            <!-- PETA INTERAKTIF -->
            <div class="dropdown nav-dropdown">
                <a class="nav-link dropdown-toggle text-black active text-decoration-none px-3" href="#" id="petaDropdown" aria-expanded="false">
                    <span class="nav-text me-1">PETA INTERAKTIF</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="petaDropdown">
                    <li>
                        <a class="dropdown-item <?= ($currentPage == 'petaDesa.php') ? 'active disabled text-secondary' : '' ?>"
                            href="<?= ($currentPage != 'petaDesa.php') ? '../../Halaman/profil/petaDesa.php' : '#' ?>">
                            Peta Desa (Umum)
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Objek wisata -->
            <a href="../../Halaman/wisata.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">OBJEK WISATA</span></a>
            <!-- umkm desa -->
            <a href="../../Halaman/umkmDesa.php" class="nav-link text-black text-decoration-none px-3"><span class="nav-text">UMKM DESA</span></a>
        </div>
    </header>

    <main class="container mt-5 mb-5">
        <h2 class="text-center pb-3 text-black font-poppins" style="font-size: 2.5rem; font-weight: 800;">
            PETA DESA INTERAKTIF
        </h2>
        <p class="fs-5 text-muted text-center mb-4">
            Menyajikan informasi lokasi penting di wilayah Desa Teniga secara interaktif, meliputi fasilitas pemerintahan, pendidikan, kesehatan, dan tempat ibadah.
        </p>
        <hr class="w-25 mx-auto">

        <div class="row g-4">
            <div class="col-lg-9">
                <div id="map-container">
                    <div id="map" class="w-100 h-100 rounded-4">
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div id="sidebar" class="bg-white p-4 rounded-4 shadow-lg border">
                    <h2 class="h5 text-dark mb-3 d-flex align-items-center">
                        <i data-lucide="map" class="me-2 text-primary"></i>
                        Kontrol & Informasi
                    </h2>

                    <p class="text-secondary mb-4 small">
                        Gunakan kontrol lapisan (kanan atas peta) untuk mengganti peta dasar atau mengaktifkan/menonaktifkan kelompok titik lokasi.
                    </p>

                    <div class="mt-3 pt-3 border-top border-gray-200">
                        <h3 class="h6 text-dark mb-2 fw-semibold">Legenda Marker</h3>
                        <ul class="list-unstyled small text-secondary space-y-2">
                            <li class="d-flex align-items-center mb-1">
                                <div class="me-2 rounded-circle border border-2 border-primary" style="width: 14px; height: 14px; background-color: #BFDBFE;"></div>
                                Batas Wilayah Desa (Circle)
                            </li>
                            <li class="d-flex align-items-center mb-1">
                                <i data-lucide="building-2" class="me-2" style="color: #0d6efd; fill: #cfe2ff; width: 16px; height: 16px; stroke-width: 2.5;"></i>
                                Pusat Pemerintahan
                            </li>
                            <li class="d-flex align-items-center mb-1">
                                <i data-lucide="hospital" class="me-2" style="color: #dc3545; fill: #f8d7da; width: 16px; height: 16px; stroke-width: 2.5;"></i>
                                Kesehatan
                            </li>
                            <li class="d-flex align-items-center mb-1">
                                <i data-lucide="school" class="me-2" style="color: #198754; fill: #d1e7dd; width: 16px; height: 16px; stroke-width: 2.5;"></i>
                                Pendidikan
                            </li>
                            <li class="d-flex align-items-center mb-1">
                                <i data-lucide="store" class="me-2" style="color: #ffc107; fill: #fff3cd; width: 16px; height: 16px; stroke-width: 2.5;"></i>
                                UMKM / Pasar
                            </li>
                            <li class="d-flex align-items-center mb-1">
                                <i data-lucide="moon-star" class="me-2" style="color: #6f42c1; fill: #c8bfe7; width: 16px; height: 16px; stroke-width: 2.5;"></i>
                                Tempat Ibadah
                            </li>

                            <li class="d-flex align-items-center mb-1">
                                <i data-lucide="heart-handshake" class="me-2" style="color: #6ccc11ff; fill: #e5e1fa; width: 16px; height: 16px; stroke-width: 2.5;"></i>
                                Fasilitas Lansia/Sosial
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-white text-center py-4 mt-5" style="background-color: #0055aa;">
        <div class="container">
            <p class="small mb-0">Hak Cipta © 2025 Pemerintah Desa Teniga. Semua hak dilindungi undang-undang. | Didukung Program Kosabangsa
                <br>Universitas Bumigora | Dibuat oleh Ahmad Jul Hadi
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

    <script>
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

        // maps
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            const CENTER_LAT = -8.41812;
            const CENTER_LNG = 116.14240;
            const INITIAL_ZOOM = 15;

            var map = L.map('map').setView([CENTER_LAT, CENTER_LNG], INITIAL_ZOOM);

            // FUNGSI CUSTOM ICON DENGAN DESAIN BARU
            function createCustomIcon(iconName, category) {
                return L.divIcon({
                    className: `custom-marker-icon marker-${category}`,
                    html: `
    <div class="marker-icon-blob"></div>
    <div class="marker-icon-inner">
        <i data-lucide="${iconName}"></i>
    </div>
    `,
                    iconSize: [44, 44],
                    iconAnchor: [22, 44],
                    popupAnchor: [0, -44]
                });
            }

            const governmentGroup = new L.LayerGroup();
            const healthGroup = new L.LayerGroup();
            const educationGroup = new L.LayerGroup();
            const worshipGroup = new L.LayerGroup();
            const commerceGroup = new L.LayerGroup();
            const boundaryGroup = new L.LayerGroup();
            const socialGroup = new L.LayerGroup();

            const lokasi = [{
                    nama: "Kantor Desa Teniga",
                    koordinat: [CENTER_LAT, CENTER_LNG],
                    deskripsi: "Pusat administrasi pemerintahan Desa Teniga.",
                    kategori: "government",
                    jam: "Buka: 08.00 - 16.00",
                    icon: createCustomIcon('building-2', 'government'),
                    group: governmentGroup
                },
                {
                    nama: "Puskesmas Pembantu Teniga",
                    koordinat: [-8.4169, 116.1429],
                    deskripsi: "Pelayanan kesehatan tingkat desa untuk masyarakat.",
                    kategori: "health",
                    jam: "Buka: 07.00 - 14.00",
                    icon: createCustomIcon('hospital', 'health'),
                    group: healthGroup
                },
                {
                    nama: "SD Negeri 1 Teniga",
                    koordinat: [-8.4189, 116.1441],
                    deskripsi: "Sekolah dasar negeri di wilayah Teniga.",
                    kategori: "education",
                    jam: "Buka: 07.00 - 12.00",
                    icon: createCustomIcon('school', 'education'),
                    group: educationGroup
                },
                {
                    nama: "TK Pertiwi Teniga",
                    koordinat: [-8.4194, 116.1417],
                    deskripsi: "Taman kanak-kanak Pertiwi Teniga.",
                    kategori: "education",
                    jam: "Buka: 07.30 - 11.30",
                    icon: createCustomIcon('school', 'education'),
                    group: educationGroup
                },
                {
                    nama: "Masjid Baiturrahman Teniga",
                    koordinat: [-8.4178, 116.1436],
                    deskripsi: "Masjid utama Desa Teniga tempat ibadah warga.",
                    kategori: "worship",
                    jam: "Buka: 24 Jam",
                    icon: createCustomIcon('moon-star', 'worship'),
                    group: worshipGroup
                },
                {
                    nama: "Pasar Rakyat Teniga",
                    koordinat: [-8.4175, 116.1413],
                    deskripsi: "Pusat kegiatan ekonomi dan pasar mingguan.",
                    kategori: "commerce",
                    jam: "Buka: 06.00 - 17.00",
                    icon: createCustomIcon('store', 'commerce'),
                    group: commerceGroup
                },
                {
                    nama: "Posyandu Lansia 'Sehat Selalu'",
                    koordinat: [-8.4150, 116.1405],
                    deskripsi: "Pusat pelayanan kesehatan rutin dan kegiatan sosial untuk warga senior.",
                    kategori: "social",
                    jam: "Buka: 08.00 - 12.00 (Hari Rabu & Jumat)",
                    icon: createCustomIcon('heart-handshake', 'social'),
                    group: socialGroup
                },
                {
                    nama: "Balai Pertemuan Warga",
                    koordinat: [-8.4201, 116.1430],
                    deskripsi: "Tempat berkumpulnya komunitas, termasuk kegiatan sosial dan pertemuan warga.",
                    kategori: "social",
                    jam: "Buka: 08.00 - 21.00",
                    icon: createCustomIcon('heart-handshake', 'social'),
                    group: socialGroup
                }
            ];


            const mainCircleData = {
                nama: "Wilayah Desa Teniga",
                koordinat: [CENTER_LAT, CENTER_LNG],
                radius: 1200,
                color: '#3B82F6',
                fill: '#BFDBFE'
            };

            lokasi.forEach(tempat => {
                var marker = L.marker(tempat.koordinat, {
                    icon: tempat.icon
                }).addTo(tempat.group);

                marker.on('add', function() {
                    const iconElement = this.getElement().querySelector('.marker-icon-inner i[data-lucide]');
                    if (iconElement) {
                        lucide.createIcons({
                            attrs: iconElement.dataset,
                            elements: [iconElement]
                        });
                    }
                });

                marker.bindPopup(`
    <div class="font-inter">
        <h4 class="fw-bold fs-6 text-gray-800 mb-1">${tempat.nama}</h4>
        <p class="small text-gray-600 mb-2">${tempat.deskripsi}</p>

        <div class="d-flex align-items-center mb-2">
            <i data-lucide="clock" class="me-2 text-success" style="width: 1rem; height: 1rem;"></i>
            <span class="small text-success fw-semibold">${tempat.jam}</span>
        </div>

        <hr class="my-2 text-gray-200">
        <a href="http://maps.google.com/maps?q=${tempat.koordinat[0]},${tempat.koordinat[1]}"
            target="_blank"
            class="d-inline-flex align-items-center text-primary text-decoration-none fw-medium small transition">
            <i data-lucide="map-pin" style="width: 1rem; height: 1rem;" class="me-1"></i>
            Lihat Rute di Google Maps
        </a>
    </div>
    `).on('popupopen', function() {
                    // Re-render ikon Lucide agar ikon jam dan pin muncul
                    lucide.createIcons();
                });

            });

            const mainCircle = L.circle(mainCircleData.koordinat, {
                color: mainCircleData.color,
                fillColor: mainCircleData.fill,
                fillOpacity: 0.15,
                weight: 3,
                radius: mainCircleData.radius
            }).addTo(boundaryGroup);

            mainCircle.bindPopup(`
    <div class="font-inter">
        <h4 class="fw-bold fs-6 text-gray-800">${mainCircleData.nama}</h4>
        <p class="small text-gray-600">Perkiraan radius: ${mainCircleData.radius / 1000} km.</p>
    </div>
    `);

            // Tambahkan semua grup ke peta saat inisiasi
            governmentGroup.addTo(map);
            healthGroup.addTo(map);
            educationGroup.addTo(map);
            worshipGroup.addTo(map);
            commerceGroup.addTo(map);
            boundaryGroup.addTo(map);
            socialGroup.addTo(map);

            const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            });

            const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles © Esri — Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
                maxZoom: 18
            });

            const topographyLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                maxZoom: 17,
                attribution: 'Map data: © <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: © <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
            });

            osmLayer.addTo(map);

            const baseLayers = {
                "Peta Jalan (OSM)": osmLayer,
                "Citra Satelit (Esri)": satelliteLayer,
                "Peta Topografi": topographyLayer
            };

            const overlayLayers = {
                "Batas Wilayah Desa": boundaryGroup,
                "Pusat Pemerintahan": governmentGroup,
                "Fasilitas Kesehatan": healthGroup,
                "Fasilitas Pendidikan": educationGroup,
                "Tempat Ibadah": worshipGroup,
                "Pusat Perdagangan": commerceGroup,
                "Fasilitas Lansia/Sosial": socialGroup
            };

            L.control.layers(baseLayers, overlayLayers, {
                collapsed: window.innerWidth > 768 ? true : false
            }).addTo(map);

            // Custom Control untuk Reset View
            L.Control.ViewReset = L.Control.extend({
                onAdd: function(map) {
                    var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
                    var button = L.DomUtil.create('button', 'leaflet-control-view-reset', container);
                    button.id = 'reset-view';
                    button.innerHTML = `<i data-lucide="crosshair" style="width: 1rem; height: 1rem;"></i>`;
                    button.title = 'Reset Tampilan ke Desa Teniga';

                    L.DomEvent.on(button, 'click', function(e) {
                        map.setView([CENTER_LAT, CENTER_LNG], INITIAL_ZOOM);
                        L.DomEvent.stop(e);
                    });

                    // Render ikon Lucide di tombol control
                    setTimeout(() => lucide.createIcons({
                        attrs: {
                            class: 'w-4 h-4'
                        },
                        elements: [button.querySelector('i')]
                    }), 100);

                    return container;
                }
            });
            new L.Control.ViewReset({
                position: 'topleft'
            }).addTo(map);

            // Memastikan peta di-render dengan benar
            setTimeout(() => {
                map.invalidateSize();
            }, 100);

        });
    </script>

</body>

</html>