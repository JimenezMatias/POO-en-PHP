<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Iniciar sesión</h2>

        <form action="/auth/login" method="POST" class="formulario-login">
            <div class="form-group">
                <input type="name" name="name" placeholder="Nombre" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>
            <button class="btn" type="submit">Ingresar</button>
        </form>

        <a class="link" href="/register">¿No tenés cuenta? Registrate</a>
    </div>
</body>
</html>