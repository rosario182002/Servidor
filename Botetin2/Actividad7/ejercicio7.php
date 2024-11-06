<?php
// Función para comprobar si un número es primo
function esPrimo($numero) {
    if ($numero <= 1) {
        return false;
    }
    for ($i = 2; $i <= sqrt($numero); $i++) {
        if ($numero % $i == 0) {
            return false;
        }
    }
    return true;
}

// Inicializamos las variables
$numeros = []; // Array para almacenar los números ingresados
$numeroPrimos = 0; // Contador de números primos
$suma = 0; // Suma total de los números ingresados

// Comprobamos si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = (int)$_POST['numero'];

    // Si el número es negativo, terminamos el ciclo
    if ($numero < 0) {
        // Si se han ingresado números positivos, calculamos los resultados
        if (count($numeros) > 0) {
            // Calculamos la media
            $media = $suma / count($numeros);
            
            // Calculamos el máximo y el mínimo
            $maximo = max($numeros);
            $minimo = min($numeros);

            // Mostramos los resultados
            echo "<h2>Resultados:</h2>";
            echo "Media: $media<br>";
            echo "Máximo: $maximo<br>";
            echo "Mínimo: $minimo<br>";
            echo "Cantidad de números primos: $numeroPrimos<br>";
        } else {
            echo "No se ingresaron números positivos.<br>";
        }
    } else {
        // Si el número es positivo, lo agregamos al array y actualizamos la suma
        $numeros[] = $numero;
        $suma += $numero;
        
        // Comprobamos si el número es primo
        if (esPrimo($numero)) {
            $numeroPrimos++;
        }

        // Volver a mostrar el formulario para ingresar más números
        echo "<p>Número ingresado: $numero. Puedes ingresar otro número.</p>";
    }
}
?>

<br>
<!-- Enlace para volver a ingresar números -->
<a href="pagina.html">Ingresar otro número</a>
