<?php
session_start();
include('dbcon.php'); // Asegúrate de incluir la conexión a la base de datos

if (!isset($_SESSION['id'])) {
    header('location:index.php');
    exit();
}

$session_id = $_SESSION['id'];

// Actualizar el estado de conexión del usuario a 'conectado'
$stmt = $conn->prepare("UPDATE members SET is_online = 1 WHERE member_id = :member_id");
$stmt->bindValue(':member_id', $session_id);
$stmt->execute();

$session_query = $conn->query("SELECT * FROM members WHERE member_id = '$session_id'");
$user_row = $session_query->fetch();
$username = $user_row['firstname']." ".$user_row['lastname'];
$image = $user_row['image'];
?>
