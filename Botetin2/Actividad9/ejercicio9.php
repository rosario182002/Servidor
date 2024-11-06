<?php
// Comprobar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $email = $_POST['email'];

    // Inicializar las variables de error
    $nombreError = $edadError = $emailError = '';

    // Validar el nombre (no debe contener números)
    if (preg_match('/\d/', $nombre)) {
        $nombreError = "El nombre no debe contener números.";
    }

    // Validar la edad (debe estar entre 3 y 130 años)
    if (!filter_var($edad, FILTER_VALIDATE_INT) || $edad < 3 || $edad > 130) {
        $edadError = "La edad debe ser un número entre 3 y 130 años.";
    }

    // Validar el correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "El correo electrónico no tiene un formato válido.";
    }

    // Si no hay errores, mostramos los datos
    if (empty($nombreError) && empty($edadError) && empty($emailError)) {
        echo "<h2>Datos válidos:</h2>";
        echo "<p><strong>Nombre:</strong> $nombre</p>";
        echo "<p><strong>Edad:</strong> $edad</p>";
        echo "<p><strong>Correo Electrónico:</strong> $email</p>";
    } else {
        // Mostrar el formulario de nuevo con errores
        include('formulario.php');
    }
}
?>

