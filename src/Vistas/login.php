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

        <form action="" method="POST" class="formulario-login" id="login-form">
            <div class="form-group">
                <input type="text" name="username" placeholder="Nombre" required id="username-input">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Contraseña" required id="password-input">
            </div>
            <button class="btn" type="button" id="login-btn">Ingresar</button>
        </form>

        <a class="link" href="/register">¿No tenés cuenta? Registrate</a>
    </div>
</body>
<script src="assets/js/login.js"></script>
</html>