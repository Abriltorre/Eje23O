<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'resonancia';


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error)
    die("Error al conectar: " . $conn->connect_error);