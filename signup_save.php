<?php include('index_header.php'); ?>
<body>
<?php
include('dbcon.php');

// Obtener datos del formulario de registro
$username = $_POST['username'];
$password = $_POST['password'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];

// Insertar el nuevo usuario en la base de datos
$conn->query("INSERT INTO members (username, password, firstname, lastname, gender, image) VALUES ('$username', '$password', '$firstname', '$lastname', '$gender', 'images/No_Photo_Available.jpg')");	

// Obtener el ID del nuevo usuario
$new_user_id = $conn->lastInsertId();

// Obtener el ID de admin2
$admin_query = $conn->query("SELECT member_id FROM members WHERE username = 'admin2'");
$admin_row = $admin_query->fetch();
$admin_id = $admin_row['member_id'];

// Insertar admin2 como amigo del nuevo usuario
$conn->query("INSERT INTO friends (my_id, my_friend_id) VALUES ('$admin_id', '$new_user_id')");

// Redireccionar a la página de inicio de sesión con un mensaje de éxito
echo "<script>
        alert('Registro satisfactorio. Ingresa con tus credenciales.');
        window.location = 'index.php';
      </script>";
?>
</body>
</html>
