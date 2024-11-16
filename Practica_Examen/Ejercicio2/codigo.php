<?php
session_start();

// Inicializa la agenda en la sesión si no existe
if (!isset($_SESSION['agenda'])) {
    $_SESSION['agenda'] = [];
}

// Maneja el formulario al enviarlo
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);

    // Verifica que el nombre no esté vacío
    if ($nombre === '') {
        $mensaje = 'El nombre no puede estar vacío.';
    } else {
        // Si el nombre ya existe en la agenda
        if (isset($_SESSION['agenda'][$nombre])) {
            if ($telefono === '') {
                // Si no hay teléfono, elimina el contacto
                unset($_SESSION['agenda'][$nombre]);
                $mensaje = "El contacto '$nombre' ha sido eliminado de la agenda.";
            } else {
                // Si hay teléfono, actualiza el contacto
                $_SESSION['agenda'][$nombre] = $telefono;
                $mensaje = "El contacto '$nombre' ha sido actualizado.";
            }
        } else {
            // Si el nombre no existe en la agenda y hay teléfono, añade el contacto
            if ($telefono === '') {
                $mensaje = 'El número de teléfono no puede estar vacío.';
            } else {
                $_SESSION['agenda'][$nombre] = $telefono;
                $mensaje = "El contacto '$nombre' ha sido añadido a la agenda.";
            }
        }
    }
}
?>

<!-- Muestra la agenda -->
<h2>Contactos</h2>
<?php if (!empty($_SESSION['agenda'])): ?>
    <ul>
        <?php foreach ($_SESSION['agenda'] as $nombre => $telefono): ?>
            <li><strong><?php echo htmlspecialchars($nombre); ?>:</strong> <?php echo htmlspecialchars($telefono); ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No hay contactos en la agenda.</p>
<?php endif; ?>

<!-- Muestra mensajes -->
<?php if ($mensaje): ?>
    <p class="mensaje"><?php echo htmlspecialchars($mensaje); ?></p>
<?php endif; ?>