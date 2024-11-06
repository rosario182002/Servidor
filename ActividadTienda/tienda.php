<?php
 $precio1 = $_POST['precio1'];
 $precio2 = $_POST['precio2'];
 $precio3 = $_POST['precio3'];

 $media = ($precio1 + $precio2 + $precio3)/3;

 echo "la media es $media";
