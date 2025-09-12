const API_URL = "http://localhost";

export async function login(nombre, password) {
  const b64 = btoa(`${nombre}:${password}`);  
  
  const res = await fetch(`${API_URL}/auth/login`, {
    method: "POST",
    headers: { 
      "Authorization": `Basic ${b64}`
    }
  });

  const data = await res.json();

  if (res.ok && data.token) {
    // guardar token en localStorage
    localStorage.setItem("token", data.token);
  }

  return data;
}

export async function register(nombre, password, confirmPassword) {
  const res = await fetch(`${API_URL}/auth/register`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ nombre, password, confirmPassword })
  });
  return res.json();
}

export function getToken() {
  return localStorage.getItem("token");
}
