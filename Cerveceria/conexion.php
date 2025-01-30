<?php
// Verificar si ya se ha iniciado una sesión antes de llamar a session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Conectar a la base de datos (con el puerto correcto)
$conn = mysqli_connect("localhost", "root", "", "cerveceria", 3308);

// Verificar la conexión
if (!$conn) {
    die("Error de conexión a MySQL: " . mysqli_connect_error());
}

// Función para comprobar si el correo ya existe en la base de datos
function existe($email) {
    global $conn;
    $sql = "SELECT correo FROM usuarios WHERE correo = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $existe = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
    return $existe;
}

// Si se presiona el botón de acceso
if (isset($_POST['btnA'])) {
    // Sanitizar el email ingresado
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (existe($email)) {
        echo "El correo ya está registrado.";
    } else {
        echo "El correo no existe en la base de datos.";
    }
}
?>
