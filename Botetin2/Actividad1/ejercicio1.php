<?php
session_start();

// Inicializar el juego si no se ha iniciado
if (!isset($_SESSION['numero_a_adivinar'])) {
    $_SESSION['numero_a_adivinar'] = rand(1, 50); // Número aleatorio a adivinar
    $_SESSION['intentos'] = 6; // Intentos disponibles
    $_SESSION['mensaje'] = "Adivina el número entre 1 y 50. Tienes 6 intentos."; // Mensaje inicial
}

// Procesar intento del jugador
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adivinanza = (int)$_POST['adivinanza']; // Obtener el intento del jugador
    $_SESSION['intentos']--; // Reducir el número de intentos

    // Verificar el intento
    if ($adivinanza === $_SESSION['numero_a_adivinar']) {
        $_SESSION['mensaje'] = "¡Correcto! Has adivinado el número.";
        session_unset(); // Reiniciar el juego después de acertar
    } elseif ($_SESSION['intentos'] <= 0) {
        $_SESSION['mensaje'] = "Has perdido. El número era {$_SESSION['numero_a_adivinar']}.";
        session_unset(); // Reiniciar el juego después de perder
    } else {
        $_SESSION['mensaje'] = $adivinanza < $_SESSION['numero_a_adivinar'] 
            ? "El número es mayor. Te quedan {$_SESSION['intentos']} intentos." 
            : "El número es menor. Te quedan {$_SESSION['intentos']} intentos.";
    }
}

// Redirigir al archivo HTML para mostrar la interfaz
header('Location: ejercicio1.html');
exit();
?>
