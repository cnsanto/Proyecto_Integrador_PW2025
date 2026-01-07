document.addEventListener("DOMContentLoaded", function () {
  // Language Toggle Logic
  const inglesBtn = document.getElementById("inglesBtn");
  const espanolBtn = document.getElementById("espanolBtn");

  if (inglesBtn && espanolBtn) {
    inglesBtn.addEventListener("click", function () {
      window.location.href = "index.php?idioma=eng";
    });

    espanolBtn.addEventListener("click", function () {
      window.location.href = "index.php?idioma=esp";
    });
  }

  // Scroll Animations (Intersection Observer)
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
        observer.unobserve(entry.target); // Animate only once
      }
    });
  }, observerOptions);

  document.querySelectorAll("section").forEach((section) => {
    observer.observe(section);
  });

  // Typing Effect for Hero
  const heroTitle = document.querySelector(".hero-title span");
  if (heroTitle) {
    const text = heroTitle.getAttribute("data-text");
    if (text) {
      heroTitle.textContent = "";
      let i = 0;
      const typeWriter = () => {
        if (i < text.length) {
          heroTitle.textContent += text.charAt(i);
          i++;
          setTimeout(typeWriter, 100); // Typing speed
        }
      };
      // Start typing after a small delay
      setTimeout(typeWriter, 500);
    }
  }
});
