<?php
namespace Modelos;

use Base\Persona; // Importamos la clase base para heredar

class Empleado extends Persona
{
    public function trabajar()
    {
        return "Estoy trabajando.";
    }
}
?>