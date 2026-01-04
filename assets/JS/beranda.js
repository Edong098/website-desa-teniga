document.addEventListener("DOMContentLoaded", () => {
  if (window.lucide) {
    lucide.createIcons();
  }
});

lucide.createIcons();

(function () {
  const LONGPRESS_MS = 400;

  document.querySelectorAll(".dropdown").forEach((drop) => {
    const toggle = drop.querySelector(".dropdown-toggle");
    if (!toggle) return;

    if (!toggle.dataset.href) {
      const firstItem = drop.querySelector(".dropdown-item[href]");
      if (firstItem) toggle.dataset.href = firstItem.getAttribute("href");
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
      // long-press -> navigate
      if (dur >= LONGPRESS_MS) {
        window.location.href = toggle.dataset.href;
      }
    };

    toggle.addEventListener("touchstart", startPress, {
      passive: true,
    });
    toggle.addEventListener("mousedown", startPress);
    toggle.addEventListener("touchend", endPress);
    toggle.addEventListener("mouseup", endPress);

    toggle.addEventListener("click", function (e) {
      const href = this.dataset.href;
      const isOpen = drop.classList.contains("show");
      if (href && isOpen) {
        e.preventDefault();
        e.stopPropagation();
        window.location.href = href;
      }
    });
  });
})();

(function () {
  if ("ontouchstart" in window) return;
  if (window.matchMedia && !window.matchMedia("(hover: hover)").matches) return;

  document.querySelectorAll(".dropdown").forEach((drop) => {
    const toggle = drop.querySelector(".dropdown-toggle");
    if (!toggle) return;

    let bs = bootstrap.Dropdown.getOrCreateInstance(toggle);
    let hideTimer = null;

    drop.addEventListener("mouseenter", () => {
      if (hideTimer) {
        clearTimeout(hideTimer);
        hideTimer = null;
      }
      bs.show();
    });

    drop.addEventListener("mouseleave", () => {
      hideTimer = setTimeout(() => {
        bs.hide();
      }, 50);
    });
  });
})();

(function () {
  const mobileMenu = document.getElementById("mobile-menu");
  const openBtn = document.getElementById("mobile-menu-btn");
  const closeBtn = document.getElementById("close-menu-btn");
  const dropdownToggles = document.querySelectorAll(".mobile-dropdown-toggle");

  function toggleMobileMenu() {
    mobileMenu.classList.toggle("show");
    document.body.classList.toggle("no-scroll");
  }

  openBtn.addEventListener("click", toggleMobileMenu);
  closeBtn.addEventListener("click", toggleMobileMenu);

  // Toggle untuk Mobile Dropdown
  dropdownToggles.forEach((toggle) => {
    toggle.addEventListener("click", () => {
      const targetId = `mobile-dropdown-${toggle.dataset.target}`;
      const targetMenu = document.getElementById(targetId);
      const chevron = toggle.querySelector(".dropdown-chevron");

      targetMenu.classList.toggle("open");
      chevron.classList.toggle("rotate-180");
    });
  });
})();

document.addEventListener("DOMContentLoaded", () => {
  const iframes = document.querySelectorAll(".lazy-iframe");
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const iframe = entry.target;
        iframe.src = iframe.dataset.src;
        observer.unobserve(iframe);
      }
    });
  });
  iframes.forEach((i) => observer.observe(i));
});
