<?php
//recoge los datos del formulario
$marcaDelProducto = $_POST['Texto'];
$advertencia = $_POST['texto1'];
$fecha = $_POST['fecha'];
$alergenos = $_POST['alergenos'];

//Inicializar variables para almacenar los mensajes de error
$errorMarca = "";
$errorAdvertencia = "";
$errorFecha = "";
$errorAlergenos = "";


//verificamos si faltan datos y asignamos los mensajes de error a las variables de arriba

if ($marcaDelProducto == "") {
   print "<p class=\"aviso\">Se requiere Marca.</p>\n";
   print "\n";
}
if (empty($advertencia)) {
    $errorAdvertencia = "Es Obligatoria la advertencia sobre el abuso del consumo de alcohol";
}
if (empty($fecha)) {
    $errorFecha = "No se ha introducido la fecha";
}
if (empty($alergenos)) {
    $errorAlergenos = "Es obligatorio incluir alergenos";
}

// Si hay algún error, mostrar los errores
if (!empty($errorMarca) || !empty($errorAdvertencia) || !empty($errorFecha) || !empty($errorAlergenos)) {
    echo "<h1>No se ha podido realizar la inserción debido a los siguientes errores:</h1>";
    echo "<ul>";
    
    if (!empty($errorMarca)) {
        echo "<li>$errorMarca</li>";
    }
    if (!empty($errorAdvertencia)) {
        echo "<li>$errorAdvertencia</li>";
    }
    if (!empty($errorFecha)) {
        echo "<li>$errorFecha</li>";
    }
    if (!empty($errorAlergenos)) {
        echo "<li>$errorAlergenos</li>";
    }
    echo "</ul>";

 // Botón para regresar a la página principal
echo '<form action="index.html" method="get">
    <button type="submit">Volver a la página inicial</button>
    </form>';
} else {
// Si no hay errores, mostrar los datos correctamente
echo "<h1>Detalles de la Cerveza</h1>";
echo "<p><strong>Marca del Producto:</strong> $marcaDelProducto</p>";
echo "<p><strong>Advertencia:</strong> $advertencia</p>";
echo "<p><strong>Fecha de Consumo Preferente:</strong> $fecha</p>";
echo "<p><strong>Alergias:</strong> $alergenos</p>";
}
