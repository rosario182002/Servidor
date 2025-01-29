
<?php
session_start();
session_destroy();
header('Location: ../General/login.php');
exit();
?>