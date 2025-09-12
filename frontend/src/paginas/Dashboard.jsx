import { useEffect, useState } from "react";
import { getToken } from "../servicios/authService";

function Dashboard() {
  const [message, setMessage] = useState("");
  const token = getToken(); // token guardado en localStorage

  useEffect(() => {
    const fetchDashboard = async () => {
      if (!token) return;

      try {
        const res = await fetch("http://localhost/protegido/dashboard", {
          method: "GET",
          headers: {
            "Authorization": `Bearer ${token}`,
          },
        });

        const data = await res.json();

        if (res.ok) {
          setMessage(data.message); // mostramos mensaje del backend
        } else {
          setMessage(data.error || "No autorizado");
          // Opcional: redirigir a login si no autorizado
          window.location.href = "/login";
        }
      } catch (err) {
        console.error(err);
        setMessage("Error de conexión con el servidor");
      }
    };

    fetchDashboard();
  }, [token]);

  return (
    <div>
      <h2>Dashboard</h2>
      <p>{message}</p>
    </div>
  );
}

export default Dashboard;
