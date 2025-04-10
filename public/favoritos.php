<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

use Oianeis\ApiNba\Conexion;
use Oianeis\ApiNba\JugadoresNba;

$conexion = new Conexion();
$conexion->getConexion();

$jugadoresNba = new JugadoresNba($conexion);
$jugadoresFavoritos = $jugadoresNba->verFavoritos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <title>Jugadores Favoritos</title>
    <style>

        thead tr th {
            background-color: #003197 !important;
            color: white !important;
            text-align: center;
        }

        tbody tr {
            background-color: white;
        }

        tbody td:hover {
            background-color: #85c1e9;

            color: white;
            transition: 0.3s;
        }

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
    </style>
</head>

<body style="background-color: #d3d3d3;">
    <div class="container mt-3">
        <div class="row">

            <aside class="col-md-2 bg-white p-4 rounded shadow-sm perfil-container">
                <h4 class="text-center" style="color: #003197;">Perfil</h4>
                <p><strong>Usuario:</strong> <?php echo isset($_SESSION['usuario']) ? $_SESSION['usuario']['nombre'] : 'Invitado'; ?></p>
                <p><strong>Fecha:</strong> <?php echo date("d/m/Y"); ?></p>
                <form action="buscador.php" method="POST">
                    <button type="submit" class="btn btn-success w-100">Volver</button>
                </form>
            </aside>
            <a href="buscador.php" class="btn d-flex align-items-center justify-content-center text-white"
                style="position: fixed; top: 10px; background-color: #003197; right: 20px; width: 150px; height: 40px; padding: 6px 10px; border-radius: 6px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); font-size: 14px;">
                <i class="bi bi-search me-1"></i> Buscar Jugadores
            </a>
            <a href="index.php" class="btn d-flex align-items-center justify-content-center text-white"
                style="position: fixed; top: 10px; background-color: #003197; left: 20px; width: 150px; height: 40px; padding: 6px 10px; border-radius: 6px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); font-size: 14px;">
                <i class="bi bi-box-arrow-left me-1"></i> Salir
            </a>

            <div class="col-md-12">
                <div class="p-3 rounded bg-white shadow-sm text-center">
                    <img src="../assets/nba.jpg" alt="NBA Logo" width="175" height="100">
                </div>


                <?php if (isset($jugadoresFavoritos) && !empty($jugadoresFavoritos)): ?>
                    <div class="mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Posición</th>
                                    <th>Altura</th>
                                    <th>Peso</th>
                                    <th>Número Camiseta</th>
                                    <th>Universidad</th>
                                    <th>País</th>
                                    <th>Año Draft</th>
                                    <th>Ronda Draft</th>
                                    <th>Posición Draft</th>
                                    <th>Equipo</th>
                                    <th>Borrar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jugadoresFavoritos as $datos): ?>
                                    <tr>
                                        <form action="verEquipo.php" method="POST" class=favorito>
                                            <td hidden> <?php echo "<input type='hidden' name='id' value=\"" . $datos->id . "\" />";
                                                        ?>
                                            </td>


                                            <td><?php echo $datos->first_name; ?></td>
                                            <td><?php echo $datos->last_name; ?></td>
                                            <td><?php echo $datos->position; ?></td>
                                            <td><?php echo $datos->height . 'm'; ?></td>
                                            <td><?php echo $datos->weight . 'Kg'; ?></td>
                                            <td><?php echo $datos->numeroJersey; ?></td>
                                            <td><?php echo $datos->college; ?></td>
                                            <td><?php echo $datos->country; ?></td>
                                            <td><?php echo $datos->draft_year; ?></td>
                                            <td><?php echo $datos->draft_round; ?></td>
                                            <td><?php echo $datos->draft_number; ?></td>
                                            <td>

                                                <button type="submit" name="equipo" value="<?php echo $datos->team; ?>" class="btn btn-secondary">
                                                    Ver equipo
                                                </button>
                                        </form>
                                        </td>
                                        <td>
                                            <form action="" method="POST" class="borrar">
                                                <button type="submit" id="borrar" name="borrar" value="<?php echo $datos->id; ?>" class="btn btn-danger">
                                                    Borrar jugador
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).on('submit', '.borrar', function(event) {
        event.preventDefault();

        let id = $(this).find('button[name="borrar"]').val();
        console.log("Borrado interceptado por AJAX");
        console.log("Datos enviados:", id);

        $.ajax({
            url: 'borrarJugador.php', 
            type: 'POST',
            dataType: 'json',
            data: {
                borrar: id
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: "¡Éxito!",
                        text: "Jugador borrado correctamente",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload(); 
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: response.error || "No se pudo borrar el jugador",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: "Error",
                    text: "Hubo un problema con la solicitud.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        });
    });
</script>

</html>