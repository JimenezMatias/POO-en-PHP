// Logica login basic auth
const loginBtn = document.getElementById("login-btn");
loginBtn.addEventListener('click', async (e) => {
  e.preventDefault();

  const usernameInput = document.getElementById("username-input");
  const passwordInput = document.getElementById("password-input");
  const b64input = `${usernameInput.value}:${passwordInput.value}`;


  try {
    const response = await fetch("http://localhost/auth/login", {
      method: 'POST',
      headers: {
        "Authorization": `Basic ${btoa(b64input)}`,
        "Content-Type": "application/json"
      }
    });

    if (!response.ok) {
      const errorData = await response.json();
      alert(errorData.message);
      return;
    }

    data = await response.json();
    console.log("Token recibido:", data.token);
    // Guardar el token en el localStorage
    localStorage.setItem("jwt", data.token)

    // Redirigir al usuario a la pagina principal
    window.location.href = "/dashboard";

  } catch (err) {
    console.error("Error en el login:", err);
  }

});