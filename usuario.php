<?php 
// Importar la conexion
//Incluye el header
require 'includes/app.php';
$db = conectarDB();


// Crear un email y password
$email = "admin@gmail.com";
$password = "admin1234";

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

// Query para crear el usuario
$query = "INSERT INTO usuarios (email, password) VALUES ('${email}', '${passwordHash}')";
echo $query;

// Agregarlo a la base de datos
mysqli_query($db, $query);
