Ejercicio 7**  
   Crea una interfaz `Comunicable` con un método `enviarMensaje`. Define clases `Correo` y `Texto` que implementen `enviarMensaje`. Recorre un arreglo ejecutando el método.
/
<?php
// Definición de la interfaz Comunicable
interface Comunicable {
    // Método abstracto que las clases deben implementar
    public function enviarMensaje();
}

// Clase Correo que implementa Comunicable
class Correo implements Comunicable {
    private $direccion;

    // Constructor para inicializar la dirección de correo
    public function __construct($direccion) {
        $this->direccion = $direccion;
    }

    public function enviarMensaje() {
        echo "Enviando un correo a: $this->direccion.\n";
    }
}

// Clase Texto que implementa Comunicable
class Texto implements Comunicable {
    private $numeroTelefono;

    // Constructor para inicializar el número de teléfono
    public function __construct($numeroTelefono) {
        $this->numeroTelefono = $numeroTelefono;
    }

    public function enviarMensaje() {
        echo "Enviando un mensaje de texto al número: $this->numeroTelefono.\n";
    }
}

// Crear un arreglo de objetos que implementen Comunicable
$mensajes = [
    new Correo("usuario@example.com"), // Objeto de tipo Correo
    new Texto("123456789"),           // Objeto de tipo Texto
    new Correo("contacto@correo.com"), // Otro objeto de tipo Correo
    new Texto("987654321")            // Otro objeto de tipo Texto
];

// Recorrer el arreglo y ejecutar el método enviarMensaje
foreach ($mensajes as $mensaje) {
    $mensaje->enviarMensaje();
}
?>
