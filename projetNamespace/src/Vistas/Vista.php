<?php
namespace Vistas;

use Contratos\Renderable;

class Vista implements Renderable
{
    public function renderizar()
    {
        return true;
    }
}
?>