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

    // Obtener los datos del formulario
    $member_id = $_POST['member_id'];
    $rol = $_POST['rol'];

    // Actualizar el rol en la base de datos
    $sql = "UPDATE members SET rol='$rol' WHERE member_id='$member_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Rol actualizado correctamente";
    } else {
        echo "Error al actualizar el rol: " . $conn->error;
    }

    $conn->close();
?>
