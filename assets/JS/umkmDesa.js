// Inisialisasi Lucide Icons
lucide.createIcons();

// Dropdown Mobile Toggle Bisa buka & tutup kembali
document.querySelectorAll(".mobile-menu .dropdown-toggle").forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();

    const submenu = btn.nextElementSibling;
    const isOpen = submenu.classList.contains("show");

    // Tutup semua submenu lain dulu
    document
      .querySelectorAll(".mobile-menu .dropdown-menu.show")
      .forEach((menu) => {
        if (menu !== submenu) {
          menu.classList.remove("show");
        }
      });
    document
      .querySelectorAll(".mobile-menu .dropdown-toggle.show")
      .forEach((toggle) => {
        if (toggle !== btn) {
          toggle.classList.remove("show");
        }
      });

    // Toggle submenu yang diklik
    submenu.classList.toggle("show", !isOpen);
    btn.classList.toggle("show", !isOpen);
  });
});

// LOGIKA MENU HAMBURGER UTAMA
(function () {
  const mobileMenu = document.getElementById("mobile-menu");
  const openBtn = document.getElementById("mobile-menu-btn");
  const closeBtn = document.getElementById("close-menu-btn");

  function toggleMobileMenu() {
    mobileMenu.classList.toggle("show");
    document.body.classList.toggle("no-scroll");
  }

  openBtn.addEventListener("click", toggleMobileMenu);
  closeBtn.addEventListener("click", toggleMobileMenu);
})();

// LOGIKA MODAL WHATSAPP
const waNumber = "6285333147733";
const waModalElement = document.getElementById("waModal");
const waProdukInput = document.getElementById("waProduk");

// Saat modal dibuka, ambil data-produk dari tombol yang diklik
waModalElement.addEventListener("show.bs.modal", function (event) {
  const button = event.relatedTarget;
  const produkNama = button.getAttribute("data-produk");
  waProdukInput.value = produkNama;
});

// Handle Submit Form
document.getElementById("waForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const nama = document.getElementById("namaPemesan").value;
  const alamat = document.getElementById("alamatLengkap").value;
  const qty = document.getElementById("jumlah").value;
  const produk = waProdukInput.value;

  const pesan =
    `Halo, saya ingin memesan produk berikut:\n\n` +
    `Produk: ${produk}\n` +
    `Nama: ${nama}\n` +
    `Alamat: ${alamat}\n` +
    `Jumlah: ${qty}\n\n` +
    `Mohon info ketersediaannya. Terima kasih.`;

  window.open(
    `https://wa.me/${waNumber}?text=${encodeURIComponent(pesan)}`,
    "_blank"
  );
});

// Logika Menu Mobile
const mobileMenu = document.getElementById("mobile-menu");
const openBtn = document.getElementById("mobile-menu-btn");
const closeBtn = document.getElementById("close-menu-btn");

if (openBtn && closeBtn) {
  openBtn.onclick = () => {
    mobileMenu.classList.add("show");
    document.body.style.overflow = "hidden";
  };
  closeBtn.onclick = () => {
    mobileMenu.classList.remove("show");
    document.body.style.overflow = "auto";
  };
}
