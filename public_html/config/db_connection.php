<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "pruebatecnicadb";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {

}

// Cerrar conexión
?>