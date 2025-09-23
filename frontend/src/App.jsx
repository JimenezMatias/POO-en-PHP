import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./paginas/Login";
import Register from "./paginas/Register";
import Dashboard from "./paginas/Dashboard";
import ProtectedRoute from "./componentes/ProtectedRoute";
import FormasDePago from "./paginas/FormasDePago";
import Localidades from "./paginas/Localidades";
import Rubros from "./paginas/Rubros";

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />

        {/* Rutas protegidas */}
        <Route
          path="/dashboard"
          element={
            <ProtectedRoute>
              <Dashboard />
            </ProtectedRoute>
          }
        >
          <Route path="formasDePago" element={<FormasDePago />} />
          <Route path="localidades" element={<Localidades />} />
          <Route path="rubros" element={<Rubros />} />
        </Route>



        {/* Default */}
        <Route path="/" element={<Login />} />
      </Routes>
    </Router>
  );
}

export default App;

