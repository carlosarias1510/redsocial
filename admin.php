<?php
session_start();
include('dbcon.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
}

// Obtener el rol del usuario autenticado
$user_id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT rol FROM members WHERE member_id = :member_id");
$stmt->bindValue(':member_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();

// Verificar si el usuario tiene el rol de administrador (rol = 1)
if ($user['rol'] != 1) {
    header('Location: home.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Table</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<table>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Contraseña</th>
            <th>Rol</th>
            <th>Actualizar Rol</th>
        </tr>
    </thead>
    <tbody>
        <?php
            // Conexión a la base de datos
            $servername = "localhost";
            $username = "admin2";
            $password = "12345";
            $dbname = "socialdb";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Consulta SQL para obtener los datos de la tabla members
            $sql = "SELECT member_id, username, password, rol FROM members";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Mostrar los datos en la tabla
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row["username"]."</td><td>".$row["password"]."</td><td>".$row["rol"]."</td>";
                    echo "<td><button onclick='actualizarRol(".$row["member_id"].")'>Actualizar</button></td></tr>";
                }
            } else {
                echo "0 resultados";
            }
            $conn->close();
        ?>
    </tbody>
</table>

<script>
    function actualizarRol(memberId) {
        var nuevoRol = prompt("Ingrese el nuevo rol (1 para Administrador, 2 para Lector):");
        if (nuevoRol !== null) {
            // Enviar los datos al servidor utilizando AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert(xhr.responseText); // Mostrar mensaje de éxito
                        // Actualizar la tabla sin recargar la página (opcional)
                    } else {
                        alert('Error al actualizar el rol');
                    }
                }
            };
            xhr.open("POST", "editar_rol.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("member_id=" + memberId + "&rol=" + nuevoRol);
        }
    }
</script>

<!-- Botón para volver a home.php -->
<a href="home.php"><button>Volver a Home</button></a>

</body>
</html>
