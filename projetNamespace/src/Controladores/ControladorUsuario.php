<?php
namespace Controladores;

use Modelos\Usuario;

class ControladorUsuario {
    public function inicio(): string {
        return "Pagina de usuarios";
    }

    public function mostrarNombre() {
        $usuario = new usuario();
        echo "nombre del usuario: " . $usuario->obtenerNombre();
    }
}
?>