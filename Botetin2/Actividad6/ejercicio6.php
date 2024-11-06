<?php
// Inicializamos un array vacío para almacenar los números
$numeros = array();

// Pedir al usuario que ingrese 10 números
echo "Por favor ingresa 10 números:\n";

// Recolectamos los 10 números del usuario
for ($i = 0; $i < 10; $i++) {
    $numeros[$i] = (int)readline("Número " . ($i + 1) . ": ");
}

// Mostrar el array original
echo "\nArray original:\n";
foreach ($numeros as $indice => $numero) {
    echo "[$indice] => $numero" . PHP_EOL; // Usamos PHP_EOL para salto de línea
}

// Filtrar los números pares e impares
$pares = array_filter($numeros, function($num) {
    return $num % 2 == 0;
});
$impares = array_filter($numeros, function($num) {
    return $num % 2 != 0;
});

// Reindexar los arrays para evitar posibles índices no consecutivos después de aplicar array_filter
$pares = array_values($pares);
$impares = array_values($impares);

// Mostrar los arrays de pares e impares
echo "\nPares: ";
print_r($pares);
echo "Impares: ";
print_r($impares);

// Reorganizar el array de forma alterna: par, impar, par, impar...
$resultado = array();
$maxLength = max(count($pares), count($impares));

// Alternar entre pares e impares
for ($i = 0; $i < $maxLength; $i++) {
    if (isset($pares[$i])) {
        $resultado[] = $pares[$i];
    }
    if (isset($impares[$i])) {
        $resultado[] = $impares[$i];
    }
}

// Mostrar el array resultante
echo "\nArray resultante:\n";
foreach ($resultado as $indice => $numero) {
    echo "[$indice] => $numero" . PHP_EOL; // Usamos PHP_EOL para salto de línea
}
?>
