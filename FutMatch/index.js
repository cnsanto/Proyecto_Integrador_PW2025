document.addEventListener("DOMContentLoaded", function () {
  const inglesBtn = document.getElementById("inglesBtn");
  const espanolBtn = document.getElementById("espanolBtn");

  inglesBtn.addEventListener("click", function () {
    inglesBtn.classList.add("active");
    espanolBtn.classList.remove("active");
    window.location.href = "index.php?idioma=eng";
  });

  espanolBtn.addEventListener("click", function () {
    espanolBtn.classList.add("active");
    inglesBtn.classList.remove("active");
    window.location.href = "index.php?idioma=esp";
  });
});
