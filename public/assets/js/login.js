// Logica login basic auth
const loginBtn = document.getElementById("login-btn");
loginBtn.addEventListener('click', async (e) => {
  e.preventDefault();

  const usernameInput = document.getElementById("username-input");
  const passwordInput = document.getElementById("password-input");
  const b64input = `${usernameInput.value}:${passwordInput.value}`;

  const response = await fetch("http://localhost/auth/login", {
    method: 'POST',
    headers: {
      "Authorization": `Basic  ${btoa(b64input)}`
    }
  })   

  if (response.ok) {
    data = await response.json();
    localStorage.setItem("jwt", data.token)
  }
})