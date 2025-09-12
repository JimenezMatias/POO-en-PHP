import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./paginas/Login";
import Register from "./paginas/Register";
import Dashboard from "./paginas/Dashboard";
import ProtectedRoute from "./componentes/ProtectedRoute";

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />

        {/* Rutas protegidas */}
        <Route path="/dashboard" element={
          <ProtectedRoute>
            <Dashboard />
          </ProtectedRoute>
        } />


        {/* Default */}
        <Route path="/" element={<Login />} />
      </Routes>
    </Router>
  );
}

export default App;

