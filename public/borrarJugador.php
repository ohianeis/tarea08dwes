<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Oianeis\ApiNba\Conexion;
use Oianeis\ApiNba\JugadoresNba;

function borrarJugador($id) {
    $conexion = new Conexion();
    $pdo = $conexion->getConexion(); // Aseguramos que obtenemos la conexión
    if (!$pdo) {
        return ['error' => 'Error de conexión a la base de datos'];
    }

    // Pasamos la conexión y los datos correctamente
    $jugadores = new JugadoresNba($pdo);
    $respuesta = $jugadores->borrarJugador($id);

    if ($respuesta === true) {
        return ['success' => true];
    } else {
        return ['error' => $respuesta]; // ✅ Lo mismo aquí
    }
}

// Validar que $_POST tiene datos antes de procesar
if (empty($_POST)) {
    echo json_encode(['error' => 'No se recibieron datos válidos']);
    exit;
}

header('Content-Type: application/json');
echo json_encode(borrarJugador($_POST));