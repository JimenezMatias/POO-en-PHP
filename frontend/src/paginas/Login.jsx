import { useState } from "react";
import { login } from "../servicios/authService";
import { useProductos } from "../context/ProductosContext";
import { useNavigate } from "react-router-dom";

function Login() {
  const [nombre, setNombre] = useState("");
  const [password, setPassword] = useState("");
  const { fetchProductos } = useProductos();
  const navigate = useNavigate();

  const handleLogin = async () => {
    try {
      const data = await login(nombre, password);
      if (data.token) {
        alert("Login correcto!");
        await fetchProductos(); // precarga
        navigate("/dashboard"); // navegación sin recarga
      } else {
        alert("Credenciales inválidas");
      }
    } catch (err) {
      console.error(err);
      alert("Error en el servidor");
    }
  };

  return (
    <div>
      <h2>Iniciar Sesión</h2>
      <input 
        type="text" 
        placeholder="Nombre"
        value={nombre}
        onChange={e => setNombre(e.target.value)}
      />
      <input 
        type="password" 
        placeholder="Contraseña"
        value={password}
        onChange={e => setPassword(e.target.value)}
      />
      <button onClick={handleLogin}>Entrar</button>
    </div>
  );
}

export default Login;
