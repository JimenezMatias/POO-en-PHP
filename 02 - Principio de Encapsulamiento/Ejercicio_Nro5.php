**Ejercicio 5**  
   Crea una clase `Estudiante` con una propiedad privada `calificaciones` (arreglo). Incluye un constructor, un método `getPromedio` para calcular el promedio y un método `agregarCalificacion` que valide valores entre 0 y 10. Prueba el promedio.
/
<?php
class Estudiante {
    // Propiedad privada
    private $calificaciones;

    // Constructor para inicializar el arreglo de calificaciones
    public function __construct() {
        $this->calificaciones = []; // Inicialización como arreglo vacío
    }

    // Método para agregar una calificación válida
    public function agregarCalificacion($calificacion) {
        if ($calificacion >= 0 && $calificacion <= 10) {
            $this->calificaciones[] = $calificacion; // Añadir al arreglo
            echo "Calificación $calificacion agregada correctamente.\n";
        } else {
            echo "La calificación debe estar entre 0 y 10.\n";
        }
    }

    // Método para calcular el promedio
    public function getPromedio() {
        if (count($this->calificaciones) > 0) {
            $suma = array_sum($this->calificaciones);
            $promedio = $suma / count($this->calificaciones);
            return $promedio;
        } else {
            echo "No hay calificaciones para calcular el promedio.\n";
            return null;
        }
    }
}

// Prueba con un objeto
$estudiante = new Estudiante(); // Crear instancia de Estudiante
$estudiante->agregarCalificacion(8); // Agregar calificación válida
$estudiante->agregarCalificacion(6); // Agregar calificación válida
$estudiante->agregarCalificacion(12); // Intentar agregar calificación inválida

$promedio = $estudiante->getPromedio(); // Calcular el promedio
if ($promedio !== null) {
    echo "El promedio de calificaciones es: $promedio\n";
}
?>

