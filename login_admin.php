<?php
session_start();

// Verificar si el usuario y la contraseña son correctos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if ($usuario === 'admin2' && $contrasena === '12345') {
        $_SESSION['loggedin'] = true;
        header("Location: admin.php"); // Redirigir al usuario a admin.php
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            margin: 0 auto;
            width: 300px;
            padding: 20px;

            border-radius: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 5px;
            margin: 5px 0;

            border-radius: 3px;
        }
        input[type="submit"], .button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover, .button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h2>Gestión</h2>
    <?php if (isset($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>
    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario" required>
    <label for="contrasena">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena" required>
    <input type="submit" value="Iniciar Sesión">
</form>

<!-- Botón para cerrar sesión -->
<form action="logout.php" method="post">
    <button class="button" type="submit">Cerrar Sesión</button>
</form>

</body>
</html>
