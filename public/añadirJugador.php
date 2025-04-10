<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Oianeis\ApiNba\Conexion;
use Oianeis\ApiNba\JugadoresNba;

function añadirJugador($datos) {
    $conexion = new Conexion();
    $pdo = $conexion->getConexion(); // Aseguramos que obtenemos la conexión
    if (!$pdo) {
        return ['error' => 'Error de conexión a la base de datos'];
    }

    // Pasamos la conexión y los datos correctamente
    $jugadores = new JugadoresNba($pdo);
    $respuesta = $jugadores->añadirFavorito($datos);

    if ($respuesta === true) {
        return ['success' => true];
    } elseif (is_string($respuesta)) {
        return ['info' => $respuesta]; // ✅ Evita la asignación dentro del return
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
echo json_encode(añadirJugador($_POST));
