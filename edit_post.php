<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
}

// Incluye el archivo de conexión a la base de datos
include('dbcon.php');

// Obtiene el nombre de usuario del usuario autenticado
$user_query = $conn->prepare("SELECT username FROM members WHERE member_id = :member_id");
$user_query->bindValue(':member_id', $_SESSION['id']);
$user_query->execute();
$user = $user_query->fetch(PDO::FETCH_ASSOC);
$user_query->closeCursor();
$is_admin = $user['username'] === 'admin2';

// Verifica si se ha enviado el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos del formulario
    $post_id = $_POST['post_id'];
    $edited_text = $_POST['edited_text'];

    // Actualiza el texto en la base de datos
    $stmt = $conn->prepare("UPDATE post SET content = :content WHERE post_id = :post_id");
    $stmt->bindValue(':content', $edited_text);
    $stmt->bindValue(':post_id', $post_id);
    $stmt->execute();
    $stmt->closeCursor(); // Cierra la consulta preparada

    // Redirige de vuelta a la página de inicio o a donde sea apropiado
    header('Location: home.php');
    exit();
}

// Verifica si se ha proporcionado un ID de publicación para editar
if (!isset($_GET['id'])) {
    header('Location: home.php'); // Redirige si no se proporciona un ID válido
    exit();
}

// Obtiene el ID de la publicación a editar
$post_id = $_GET['id'];

// Consulta la publicación en la base de datos
$stmt = $conn->prepare("SELECT * FROM post WHERE post_id = :post_id");
$stmt->bindValue(':post_id', $post_id);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor(); // Cierra la consulta preparada

// Verifica si la publicación existe y si el usuario actual es el autor de la publicación o si es admin2
if (!$post || (!$is_admin && $post['member_id'] !== $_SESSION['id'])) {
    header('Location: home.php'); // Redirige si la publicación no existe o no es del usuario actual y no es admin2
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Publicación</title>
</head>
<body>
    <h1>Editar Publicación</h1>
    <form action="" method="post">
        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
        <textarea name="edited_text" rows="10" cols="50"><?php echo htmlspecialchars($post['content']); ?></textarea><br>
        <input type="submit" value="Guardar Cambios">
    </form>
</body>
</html>
