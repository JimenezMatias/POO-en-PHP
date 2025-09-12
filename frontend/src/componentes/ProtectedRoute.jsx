import { Navigate } from "react-router-dom";
import { getToken } from "../servicios/authService";

function ProtectedRoute({ children }) {
  const token = getToken();
  if (!token) {
    return <Navigate to="/login" />;
  }
  // Leer rol del JWT
  const payload = JSON.parse(atob(token.split('.')[1]));
  const userRole = payload.rol;

  // Validar rol
  if (userRole !== 1) {
    return <Navigate to="/login" />; // o a una página "no autorizado"
  }
  return children;
}

export default ProtectedRoute;
