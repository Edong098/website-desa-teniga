<!-- Data tb_peta_desa belum dimasukkan -->
<?php
include "../../database/dbConnect.php";
$conn = isset($konek) ? $konek : null;
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
                style="margin-left: 11%; transform: translateY(8px); margin-bottom: -9px;">
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
                    <a class="nav-link dropdown-toggle text-black text-decoration-none px-3 " href="#" id="profilDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-text me-1">PROFIL DESA</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="profilDropdown">
                        <li><a class="dropdown-item" href="lembaga.php">Lembaga Desa</a></li>
                        <li><a class="dropdown-item" href="demografi.php">Demografi</a></li>
                    </ul>
                </div>

                <div class="dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle text-black text-decoration-none px-3 active" href="#" id="petaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
            <p class="mb-0 small opacity-75">
                Hak Cipta ©2025 Teniga. Creative Business |
                Diciptakan oleh
                <a href="#" class="text-white hover-underline-opacity-75 transition">Rara Theme</a>.
                Ditenagai oleh
                <a href="#" class="text-white hover-underline-opacity-75 transition">WordPress</a>.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

    <script>
        // dropdown
        lucide.createIcons();

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
                    icon: createCustomIcon('building-2', 'government'),
                    group: governmentGroup
                },
                {
                    nama: "Puskesmas Pembantu Teniga",
                    koordinat: [-8.4169, 116.1429],
                    deskripsi: "Pelayanan kesehatan tingkat desa untuk masyarakat.",
                    kategori: "health",
                    icon: createCustomIcon('hospital', 'health'),
                    group: healthGroup
                },
                {
                    nama: "SD Negeri 1 Teniga",
                    koordinat: [-8.4189, 116.1441],
                    deskripsi: "Sekolah dasar negeri di wilayah Teniga.",
                    kategori: "education",
                    icon: createCustomIcon('school', 'education'),
                    group: educationGroup
                },
                {
                    nama: "TK Pertiwi Teniga",
                    koordinat: [-8.4194, 116.1417],
                    deskripsi: "Taman kanak-kanak Pertiwi Teniga.",
                    kategori: "education",
                    icon: createCustomIcon('school', 'education'),
                    group: educationGroup
                },
                {
                    nama: "Masjid Baiturrahman Teniga",
                    koordinat: [-8.4178, 116.1436],
                    deskripsi: "Masjid utama Desa Teniga tempat ibadah warga.",
                    kategori: "worship",
                    icon: createCustomIcon('moon-star', 'worship'),
                    group: worshipGroup
                },
                {
                    nama: "Pasar Rakyat Teniga",
                    koordinat: [-8.4175, 116.1413],
                    deskripsi: "Pusat kegiatan ekonomi dan pasar mingguan.",
                    kategori: "commerce",
                    icon: createCustomIcon('store', 'commerce'),
                    group: commerceGroup
                },
                {
                    nama: "Posyandu Lansia 'Sehat Selalu'",
                    koordinat: [-8.4150, 116.1405],
                    deskripsi: "Pusat pelayanan kesehatan rutin dan kegiatan sosial untuk warga senior.",
                    kategori: "social",
                    icon: createCustomIcon('heart-handshake', 'social'),
                    group: socialGroup
                },
                {
                    nama: "Balai Pertemuan Warga",
                    koordinat: [-8.4201, 116.1430],
                    deskripsi: "Tempat berkumpulnya komunitas, termasuk kegiatan sosial dan pertemuan warga lanjut usia.",
                    kategori: "social",
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
                        <h4 class="fw-bold fs-6 text-gray-800">${tempat.nama}</h4>
                        <p class="small text-gray-600">${tempat.deskripsi}</p>
                        <hr class="my-2 text-gray-200">
                        <a href="http://maps.google.com/maps?q=$${tempat.koordinat[0]},${tempat.koordinat[1]}" target="_blank" class="d-inline-flex align-items-center text-primary text-decoration-none fw-medium small transition">
                            <i data-lucide="map-pin" style="width: 1rem; height: 1rem;" class="me-1"></i>
                            Lihat Rute di Google Maps
                        </a>
                    </div>
                `).on('popupopen', function() {
                    // Re-render Lucide Icons di dalam popup juga
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