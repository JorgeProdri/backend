<?php
date_default_timezone_set('America/Guayaquil');

$host = "localhost";
$port = "3306";
$user = "root";
$pass = "";
$db = "cacao";
$charset = "utf8mb4";

function is_Win()
{
    return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
}

if (is_Win()) {
    // para pruebas usar credenciales locales
    $user = "root";
    $pass = "";
}

$mysqli = new mysqli($host, $user, $pass, $db, $port);

$mysqli->set_charset("utf8");

if ($mysqli->connect_errno) {
    echo json_encode(array("error" => true, "message" => "No se pudo conectar a la base de datos: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error));
} else {
    echo "Conexión exitosa a la base de datos.";
    // Puedes realizar consultas y operaciones con la base de datos aquí
}

// Cerrar la conexión al finalizar
$mysqli->close();
?>
