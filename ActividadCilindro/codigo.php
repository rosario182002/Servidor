<?php
$caudal = $_REQUEST['caudal'];
$radio = $_REQUEST['radio'];
$altura = $_REQUEST['altura'];
$pi = 3.14;
$deposito = $pi * ($radio*$radio)* $altura;

$litos = $deposito/1000;

$tiempo = $litos/$caudal;

echo'el tiempo es: '.$tiempo.'';
