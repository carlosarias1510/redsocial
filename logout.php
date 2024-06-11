<?php
session_start();
include('dbcon.php'); // Asegúrate de incluir la conexión a la base de datos

if (isset($_SESSION['id'])) {
    $session_id = $_SESSION['id'];
    
    // Actualizar el estado de conexión del usuario
    $stmt = $conn->prepare("UPDATE members SET is_online = 0 WHERE member_id = :member_id");
    $stmt->bindValue(':member_id', $session_id);
    $stmt->execute();
}

session_destroy();
header('location:index.php');
exit();
?>
