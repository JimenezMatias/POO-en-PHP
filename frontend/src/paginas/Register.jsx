import { useState } from "react";
import { register } from "../servicios/authService";
import { useNavigate } from "react-router-dom";

function Register() {
  const [nombre, setNombre] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const navigate = useNavigate();

  const handleRegister = async () => {
    try {
      const data = await register(nombre, password, confirmPassword);
      alert(data.message);

      if (data.status === "success") {
        navigate("/login"); // redirige al login en el frontend
      }
    } catch (err) {
      console.error(err);
      alert("Error al registrar");
    }
  };

  return (
    <div>
      <h2>Registro</h2>
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
      <input 
        type="password" 
        placeholder="Contraseña"
        value={confirmPassword}
        onChange={e => setConfirmPassword(e.target.value)}
      />
      <button onClick={handleRegister}>Crear cuenta</button>
    </div>
  );
}

export default Register;
