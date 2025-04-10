<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

use Oianeis\ApiNba\Conexion;
use Oianeis\ApiNba\JugadoresNba;


$idJugador = '';
$idEquipo = '';

if (isset($_POST)) {
    $idJugador = $_POST['id'];
    $idJugador = intval($idJugador);
    $idEquipo = $_POST['equipo'];
    $idEquipo = intval($idEquipo);
} else {
    header("Location: favoritos.php");
}


$conexion = new Conexion();
$conexion->getConexion();
$jugadoresNba = new JugadoresNba($conexion);
$jugador = $jugadoresNba->verJugador($idJugador);
$api = new Oianeis\ApiNba\ApiCliente();
$resultado = $api->getDatos("teams", $idEquipo);
$resultado = $resultado['data'];

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <title>Detalles Jugador y Equipo</title>
    <style>
        .perfil-container {
            width: 180px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            position: absolute;
            left: 15px;
            top: 120px;
        }

        .contenedor-datos {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>

<body style="background-color: #d3d3d3;">
    <div class="container mt-3">
        <div class="row">
            <aside class="col-md-1 bg-white p-3 rounded shadow-sm perfil-container">
                <h4 class="text-center" style="color: #003197;">Perfil</h4>
                <p><strong>Usuario:</strong> <?php echo isset($_SESSION['usuario']) ? $_SESSION['usuario']['nombre'] : 'Invitado'; ?></p>
                <p><strong>Fecha:</strong> <?php echo date("d/m/Y"); ?></p>
                <form action="favoritos.php" method="POST">
                    <button type="submit" class="btn btn-success w-100">Volver</button>
                </form>
            </aside>

            <a href="buscador.php" class="btn d-flex align-items-center justify-content-center text-white"
                style="position: fixed; top: 10px;background-color: #003197; right: 20px; width: 150px; height: 40px; padding: 6px 10px; border-radius: 6px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); font-size: 14px;">
                <i class="bi bi-search me-1"></i> Buscar
            </a>
            <a href="index.php" class="btn d-flex align-items-center justify-content-center text-white"
                style="position: fixed; top: 10px; background-color: #003197; left: 20px; width: 150px; height: 40px; padding: 6px 10px; border-radius: 6px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); font-size: 14px;">
                <i class="bi bi-box-arrow-left me-1"></i> Salir
            </a>


            <div class="col-md-11">

                <div class="p-4 rounded bg-white shadow-sm text-center mt-4">
                    <img src="../assets/nba.jpg" alt="NBA Logo" width="200" height="110">

                </div>


                <div class="row mt-4">

                    <div class="col-md-6">
                        <div class="contenedor-datos p-5 mb-4">
                            <h2 class="text-center" style="color: #003197;">Datos del Jugador</h2>
                            <p><strong>Nombre:</strong> <?php echo $jugador->first_name; ?></p>
                            <p><strong>Apellido:</strong> <?php echo $jugador->last_name; ?></p>
                            <p><strong>Posición:</strong> <?php echo $jugador->position; ?></p>
                            <p><strong>Altura:</strong> <?php echo $jugador->height . 'm'; ?></p>
                            <p><strong>Peso:</strong> <?php echo $jugador->weight . 'Kg'; ?></p>
                            <p><strong>Número Camiseta:</strong> <?php echo isset($jugador->numeroJersey) ? $jugador->numeroJersey : 'No disponible'; ?></p>
                            <p><strong>Universidad:</strong> <?php echo $jugador->college; ?></p>
                            <p><strong>País:</strong> <?php echo $jugador->country; ?></p>
                            <p><strong>Año Draft:</strong> <?php echo isset($jugador->draft_year) ? $jugador->draft_year : 'No disponible'; ?></p>
                            <p><strong>Ronda Draft:</strong> <?php echo isset($jugador->draft_round) ? $jugador->draft_round : 'No disponible'; ?></p>
                            <p><strong>Posición Draft:</strong> <?php echo isset($jugador->draft_number) ? $jugador->draft_number : 'No disponible'; ?></p>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="contenedor-datos p-5 mb-4">
                            <h2 class="text-center" style="color: #003197;">Datos del Equipo</h2>
                            <p><strong>Conferencia:</strong> <?php echo isset($resultado['conference']) ? $resultado['conference'] : 'No disponible'; ?></p>
                            <p><strong>División:</strong> <?php echo isset($resultado['division']) ? $resultado['division'] : 'No disponible'; ?></p>
                            <p><strong>Ciudad:</strong> <?php echo isset($resultado['city']) ? $resultado['city'] : 'No disponible'; ?></p>
                            <p><strong>Nombre del Equipo:</strong> <?php echo isset($resultado['name']) ? $resultado['name'] : 'Sin equipo'; ?></p>
                            <p><strong>Nombre completo:</strong> <?php echo isset($resultado['full_name']) ? $resultado['full_name'] : 'Sin equipo'; ?></p>
                            <p><strong>Abreviación:</strong> <?php echo isset($resultado['abbreviation']) ? $resultado['abbreviation'] : 'Sin equipo'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>



</html>