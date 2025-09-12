<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Registro</h2>

        <form class="formulario-registro" id="formRegistro" action="" method="POST" novalidate>
            <div class="form-group">
                <input type="text" name="name" id="name" placeholder="Nombre" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Contraseña" required>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" id="passwordConfirm" placeholder="Confirmar Contraseña" required>
            </div>
            <button class="btn" type="submit">Registrarse</button>
        </form>

        

        <a class="link" href="/login">¿Ya tienes cuenta? Iniciar sesión</a>
    
    </div>
</body>
</html>