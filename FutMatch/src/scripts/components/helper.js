document.addEventListener("DOMContentLoaded", function () {
  const helperButton = document.getElementById("helperBtn");
  const helperModal = document.getElementById("helperModal");
  helperModal.addEventListener("shown.bs.modal", () => {
    helperModal.focus();
  });
  const body = document.getElementById("helperBody");
  const buttons = document.querySelectorAll(".btn-lang");

  buttons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const lang = btn.dataset.lang; // "ESP" o "ENG"

      if (lang === "ESP") {
        body.innerHTML = body.dataset.es;
      } else {
        body.innerHTML = body.dataset.en;
      }
    });
  });

  document.querySelectorAll(".btn-lang").forEach((btn) => {
    btn.addEventListener("click", () => {
      const lang = btn.dataset.lang === "ENG" ? "eng" : "esp";

      // Cambia el texto del modal
      const body = document.getElementById("helperBody");
      body.innerHTML = lang === "eng" ? body.dataset.en : body.dataset.es;

      // Guarda el idioma en sesión
      fetch("?idioma=" + lang);
    });
  });
});
