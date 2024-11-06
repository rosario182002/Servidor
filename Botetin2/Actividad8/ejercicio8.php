<?php
// Comprobar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $sexo = $_POST['sexo'];
    $email = $_POST['email'];
    $contacto = $_POST['contacto'];
    $experiencia = $_POST['experiencia'];
    $estudios = $_POST['estudios'];
    $jornada = $_POST['jornada'];
    $idiomas = isset($_POST['idiomas']) ? $_POST['idiomas'] : [];

    // Mostrar los datos del currículum vitae
    echo "<h1>Currículum Vitae</h1>";

    echo "<p><strong>Nombre:</strong> $nombre $apellidos</p>";
    echo "<p><strong>Sexo:</strong> $sexo</p>";
    echo "<p><strong>Correo Electrónico:</strong> $email</p>";
    echo "<p><strong>Número de Contacto:</strong> $contacto</p>";

    echo "<p><strong>Experiencia Laboral:</strong></p>";
    echo "<p>$experiencia</p>";

    echo "<p><strong>Estudios:</strong></p>";
    echo "<p>$estudios</p>";

    echo "<p><strong>Jornada Laboral Preferida:</strong> $jornada</p>";

    echo "<p><strong>Idiomas:</strong> ";
    if (count($idiomas) > 0) {
        echo implode(", ", $idiomas);
    } else {
        echo "No se seleccionaron idiomas.";
    }
    echo "</p>";
}
?>
