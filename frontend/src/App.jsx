import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./paginas/Login";
import Register from "./paginas/Register";
import Dashboard from "./paginas/Dashboard";
import ProtectedRoute from "./componentes/ProtectedRoute";
import FormasDePago from "./paginas/FormasDePago";
import Localidades from "./paginas/Localidades";
import Rubros from "./paginas/Rubros";
import Proveedores from "./paginas/Proveedores";
import Ubicaciones from "./paginas/Ubicaciones";
import Articulos from "./paginas/Articulos";
import { ArticulosProvider } from "./context/ArticulosContext";

function App() {
  return (
    <ArticulosProvider>
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
            <Route path="proveedores" element={<Proveedores />} />
            <Route path="rubros" element={<Rubros />} />
            <Route path="ubicaciones" element={<Ubicaciones />} />
            <Route path="articulos" element={<Articulos />} />
          </Route>



          {/* Default */}
          <Route path="/" element={<Login />} />
        </Routes>
      </Router>
    </ArticulosProvider>
  );
}

export default App;

