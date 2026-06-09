<?php
header('Content-Type: text/html; charset=utf-8');

$servername = "localhost";
$username = "root";
$password = "";
$basename = "pwa_projekt";

$dbc = mysqli_connect($servername, $username, $password, $basename) or die('Greška pri spajanju na MySQL server: ' . mysqli_connect_error());
mysqli_set_charset($dbc, "utf8");
?>