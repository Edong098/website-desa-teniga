// Inisialisasi Lucide Icons
lucide.createIcons();

// Dropdown Mobile Toggle — Bisa buka & tutup kembali
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
