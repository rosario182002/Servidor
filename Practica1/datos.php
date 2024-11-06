<?php

error_reporting(0);
//Recoger los datos
$tipoCerveza = $_POST['tipoCerveza'];
$denominacionAlimento = $_POST['DenominacionAlimento'];
$tipoEmbase = $_POST['TipoEmbase'];
$cantidadNeta = $_POST['CantidadNeta'];
$marcaDelProducto = $_POST['texto'];
$advertencia = $_POST['texto1'];
$fecha = $_POST['fecha'];
$alergenos= $_POST['alergenos'];
$observaciones = $_POST['observaciones'];

//Inicializar variables para almacenar los mensajes de error
$errores = [
    "marca" => $marcaDelProducto ? "" : "Tienes que introducir una marca",
    "advertencia" => $advertencia ? "" : "Es Obligatoria la advertencia sobre el alcohol",
    "fecha" => $fecha ? "" : "No se ha introducido la fecha",
    "alergenos" => $alergenos ? "" : "Es obligatorio incluir alergenos"
];


//comprueba si hay errores
$hayErrores = false;
foreach ($errores as $error) {
    if ($error) {
        $hayErrores = true;
        break;
    }
}
//Muestra los errores
if ($hayErrores) {
    echo "<h1>Errores:</h1><ul>";
        foreach ($errores as $error) {
            if ($error) echo "<li>$error</li>";
        }    
    echo "</ul><form action='pagina.html'>
    <button>Volver</button></form>";
    }else {
            //Imprimir los datos 
    echo "<h1>Detalles de la Cerveza</h1>";
    echo "<p><strong>Tipo de Cerveza:</strong> $tipoCerveza</p>";
    echo "<p><strong>Denominación del Alimento:</strong> $denominacionAlimento</p>";
    echo "<p><strong>Tipo de Embase:</strong> $tipoEmbase</p>";
    echo "<p><strong>Cantidad Neta:</strong> $cantidadNeta</p>";
    echo "<p><strong>Marca del Producto:</strong> $marcaDelProducto</p>";
    echo "<p><strong>Advertencia:</strong> $advertencia</p>";
    echo "<p><strong>Fecha de Consumo Preferente:</strong> $fecha</p>";
    echo "<p><strong>Alergias:</strong></p>";
    foreach($alergenos as $opcion){
        print $opcion ." ";
    }

    echo "<p><strong>Observaciones:</strong> $observaciones</p>";

}


//Subir Ficheros
$msgError = array(0 => "No hay error, el fichero se subió con éxito",
1 => "El tamaño del fichero supera la directiva
upload_max_filesize el php.ini",
2 => "El tamaño del fichero supera la directiva
MAX_FILE_SIZE especificada en el formulario HTML",
3 => "El fichero fue parcialmente subido",
4 => "No se ha subido un fichero",
6 => "No existe un directorio temporal",
7 => "Fallo al escribir el fichero al disco",
8 => "La subida del fichero fue detenida por la extensión");

if($_FILES["fichero"]["error"] > 0){
echo "Error: " . $msgError[$_FILES["fichero"]["error"]] . "<br />";
}
else{
echo "Nombre original: " . $_FILES["fichero"]["name"] . "<br />";
echo "Tipo: " . $_FILES["fichero"]["type"] . "<br />";
echo "Tamaño: " . ceil($_FILES["fichero"]["size"] / 1024) . " Kb<br />";
echo "Nombre temporal: " . $_FILES["fichero"]["tmp_name"] . "<br />";

if(file_exists("upload/" . $_FILES["fichero"]["name"])){
echo $_FILES["fichero"]["name"] . " ya existe";
}
else{
move_uploaded_file($_FILES["fichero"]["tmp_name"],
"upload/" . $_FILES["fichero"]["name"]);
 
echo "Almacenado en: " . "upload/" . $_FILES["fichero"]["name"];
}
}
?>
