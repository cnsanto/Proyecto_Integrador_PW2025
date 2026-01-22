document.addEventListener("DOMContentLoaded", function () {
  const helperModal = document.getElementById("helperModal");
  const body = document.getElementById("helperBody");
  const buttons = document.querySelectorAll(".btn-lang");

  // Load saved language preference from localStorage
  const savedLang = localStorage.getItem("helper_lang") || "esp";
  updateModalContent(savedLang);

  // Focus modal when shown
  helperModal.addEventListener("shown.bs.modal", () => {
    helperModal.focus();
  });

  // Language switcher buttons
  buttons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const lang = btn.dataset.lang.toLowerCase(); // "esp" or "eng"
      updateModalContent(lang);
      localStorage.setItem("helper_lang", lang);
    });
  });

  /**
   * Update modal content based on language
   * @param {string} lang - "esp" or "eng"
   */
  function updateModalContent(lang) {
    if (lang === "eng") {
      body.innerHTML = body.dataset.en;
    } else {
      body.innerHTML = body.dataset.es;
    }

    // Re-attach event listeners to demo login buttons after content update
    reattachDemoLoginListeners();
  }

  /**
   * Re-attach event listeners to demo login buttons
   * This is needed because innerHTML removes the original event listeners
   */
  function reattachDemoLoginListeners() {
    if (typeof setupDemoLogins === "function") {
      setupDemoLogins();
    }
  }
});
