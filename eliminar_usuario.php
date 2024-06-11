<?php
// Verificar si se recibió el ID del usuario a eliminar
if (isset($_POST['member_id'])) {
    // Obtener el ID del usuario a eliminar
    $memberId = $_POST['member_id'];

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "carlosarias";
    $password = "12345";
    $database = "socialdb";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Consulta SQL para eliminar el usuario
    $sql = "DELETE FROM members WHERE member_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Error al preparar la consulta.";
        exit();
    }

    $stmt->bind_param("i", $memberId);
    $result = $stmt->execute();

    if ($result === false) {
        echo "Error al eliminar el usuario: " . $stmt->error;
    } else {
        echo "¡El usuario se ha eliminado correctamente!";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Error: No se recibió el ID del usuario a eliminar.";
}
?>
