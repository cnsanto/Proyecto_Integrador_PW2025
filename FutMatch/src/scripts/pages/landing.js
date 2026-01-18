// Iniciar sesión
document.addEventListener("DOMContentLoaded", () => {
  const loginCard = document.getElementById("loginCard");
  const collapseEl = document.getElementById("loginCollapse");
  const emailInput = document.getElementById("email");

  // Instancia de Bootstrap Collapse (sin toggle automático)
  const bsCollapse = new bootstrap.Collapse(collapseEl, { toggle: false });

  // Alternar al click/touch en toda la tarjeta
  loginCard.addEventListener("click", (e) => {
    // Evita que clicks dentro del formulario vuelvan a cerrar
    if (collapseEl.contains(e.target)) return;

    const isOpen = collapseEl.classList.contains("show");
    isOpen ? bsCollapse.hide() : bsCollapse.show();
  });

  // Alternar al presionar Enter cuando la tarjeta tiene foco
  loginCard.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      const isOpen = collapseEl.classList.contains("show");
      isOpen ? bsCollapse.hide() : bsCollapse.show();
    }
  });

  // Sincroniza aria-expanded para el chevron/estilos
  collapseEl.addEventListener("show.bs.collapse", () => {
    loginCard.setAttribute("aria-expanded", "true");
  });
  collapseEl.addEventListener("hide.bs.collapse", () => {
    loginCard.setAttribute("aria-expanded", "false");
  });

  // focus mail
  collapseEl.addEventListener("shown.bs.collapse", () => {
    setTimeout(() => emailInput && emailInput.focus(), 50);
  });

  // Demo login handlers
  setupDemoLogins();
});

/**
 * Setup demo login button handlers (Dynamic mode only)
 */
function setupDemoLogins() {
  console.log("[DEMO LOGIN] Setting up demo login handlers...");

  // Dynamic demo handlers
  const jugadorBtn = document.querySelector(".login-jugador");
  const adminBtn = document.querySelector(".login-admin");
  const adminFutmatchBtn = document.querySelector(".login-admin-futmatch");

  console.log("[DEMO LOGIN] Found buttons:", {
    jugador: !!jugadorBtn,
    admin: !!adminBtn,
    adminFutmatch: !!adminFutmatchBtn,
  });

  if (jugadorBtn) {
    console.log("[DEMO LOGIN] Adding listener to jugador button");
    jugadorBtn.addEventListener("click", () => {
      console.log("[DEMO LOGIN] Jugador button clicked!");
      loginAsDemo("jugador", "dynamic");
    });
  }

  if (adminBtn) {
    console.log("[DEMO LOGIN] Adding listener to admin button");
    adminBtn.addEventListener("click", () => {
      console.log("[DEMO LOGIN] Admin button clicked!");
      loginAsDemo("admin_cancha", "dynamic");
    });
  }

  if (adminFutmatchBtn) {
    console.log("[DEMO LOGIN] Adding listener to admin futmatch button");
    adminFutmatchBtn.addEventListener("click", () => {
      console.log("[DEMO LOGIN] Admin futmatch button clicked!");
      loginAsDemo("admin_sistema", "dynamic");
    });
  }
}

/**
 * Login as demo account
 * @param {string} role - Role: 'jugador', 'admin_cancha', 'admin_sistema'
 * @param {string} mode - Mode: 'static' or 'dynamic'
 */
async function loginAsDemo(role, mode) {
  console.log("[DEMO LOGIN] Starting demo login...");
  console.log("[DEMO LOGIN] Role:", role);
  console.log("[DEMO LOGIN] Mode:", mode);

  try {
    const formData = new FormData();
    formData.append("role", role);
    formData.append("mode", mode);

    // Use global variable set in landing.php
    const demoLoginUrl =
      window.DEMO_LOGIN_URL ||
      "/Proyecto_Integrador_PW2025/FutMatch/src/controllers/demo_login_controller.php";
    console.log("[DEMO LOGIN] URL:", demoLoginUrl);

    console.log("[DEMO LOGIN] Sending fetch request...");
    const response = await fetch(demoLoginUrl, {
      method: "POST",
      body: formData,
    });

    console.log("[DEMO LOGIN] Response status:", response.status);
    console.log("[DEMO LOGIN] Response OK:", response.ok);

    // Get response text first to see what we're receiving
    const responseText = await response.text();
    console.log("[DEMO LOGIN] Raw response:", responseText);

    // Try to parse as JSON
    let result;
    try {
      result = JSON.parse(responseText);
      console.log("[DEMO LOGIN] Parsed JSON:", result);
    } catch (e) {
      console.error("[DEMO LOGIN] Failed to parse JSON:", e);
      console.error("[DEMO LOGIN] Response was:", responseText);
      throw new Error("Invalid JSON response from server");
    }

    if (result.success) {
      console.log("[DEMO LOGIN] Login successful!");
      console.log("[DEMO LOGIN] Redirect URL:", result.redirect_url);

      // Show success toast with mode-specific message
      if (window.showToast) {
        const message =
          mode === "static"
            ? "Sesión demo iniciada (solo lectura)"
            : "Cuenta demo temporal creada. Expira en 24 horas.";
        window.showToast(message, "success", 2000);
      }

      // Redirect to appropriate home page
      setTimeout(() => {
        console.log("[DEMO LOGIN] Redirecting to:", result.redirect_url);
        if (result.redirect_url) {
          window.location.href = result.redirect_url;
        } else {
          console.warn("[DEMO LOGIN] No redirect_url, reloading page");
          window.location.reload(true);
        }
      }, 500);
    } else {
      console.error("[DEMO LOGIN] Login failed");
      console.error("[DEMO LOGIN] Error message:", result.message);

      if (window.showToast) {
        window.showToast(
          result.message || "Error al iniciar sesión demo",
          "error"
        );
      } else {
        alert(result.message || "Error al iniciar sesión demo");
      }
    }
  } catch (error) {
    console.error("[DEMO LOGIN] Exception caught:", error);
    console.error("[DEMO LOGIN] Error stack:", error.stack);

    if (window.showToast) {
      window.showToast("Error al procesar la solicitud", "error");
    } else {
      alert("Error al procesar la solicitud");
    }
  }
}
