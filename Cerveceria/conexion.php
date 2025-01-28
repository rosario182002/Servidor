<?php
// $host = "localhost";      // Dirección del servidor MySQL (localhost si es local)
// $dbname = "cerveceria";    // Cambia por el nombre de tu base de datos
// $user = "root";           // Usuario de MySQL (por defecto es root)
// $pass = "";               // Contraseña de MySQL (en blanco si es local)

//abrimos bbdd
$conn = mysqli_connect ("localhost:3308","root","","cerveceria");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
if (isset($_POST['btnA'])) {//si le damos al botón de acceder
    //cojemos los valores de todos nuestros campos
    $email = $_POST['email'];
    $password = $_POST['password'];

     //comprobamos si existe en la bbdd
     function existe($email){
        global $conn;
        $sql = "SELECT correo FROM usuarios WHERE correo = '$email'";
        $existe = mysqli_query($conn, $sql);
        return mysqli_num_rows($existe) > 0;
    }
}
/*try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa"; // Mensaje para probar conexión
} catch (PDOException $e) {
    die("Error al conectar: " . $e->getMessage());
}
    */?>