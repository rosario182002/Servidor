<?php
  $estatura = array("Rosa" => 168,"Ignacio" => 175,"Daniel" => 172,"Rubén" => 182);
$estatura_daniel = $estatura["Daniel"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatura</title>
</head>
<body>
    <h1>Estatura Daniel</h1>
    <p>La estatura de Daniel es: <?php echo $estatura_daniel; ?> cm</p>
</body>
</html>