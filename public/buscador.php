<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

use Oianeis\ApiNba\ApiCliente;

$nombreJugador = null;
$apellidoJugador = null;
$resultado = null;
if (isset($_POST['buscar']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombreJugador = $_POST['nombre'] ? trim(htmlspecialchars($_POST['nombre'])) : null;

    $apellidoJugador = $_POST['apellido'] ? trim(htmlspecialchars($_POST['apellido'])) : null;
}

if ($nombreJugador && !$apellidoJugador) {
    $api = new Oianeis\ApiNba\ApiCliente();
    $resultado = $api->getDatos("players", ['first_name' => $nombreJugador]);
}
if ($nombreJugador && $apellidoJugador) {
    $api = new Oianeis\ApiNba\ApiCliente();
    $resultado = $api->getDatos("players", [
        'first_name' => $nombreJugador,
        'last_name' => $apellidoJugador
    ]);
} else if (!$nombreJugador && $apellidoJugador) {
    $api = new Oianeis\ApiNba\ApiCliente();
    $resultado = $api->getDatos("players", ['last_name' => $apellidoJugador]);
}
if (!is_array($resultado) || empty($resultado['data'])) {
    $resultado = 'No existe ningún jugador con los datos proporcionados';
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <title>Document</title>
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
            background-color: red;
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
                <form action="favoritos.php" method="POST">
                    <button type="submit" class="btn btn-success w-100">Ver Favoritos</button>
                </form>
            </aside>
            <a href="index.php" class="btn d-flex align-items-center justify-content-center text-white"
                style="position: fixed; top: 10px; background-color: #003197; left: 20px; width: 150px; height: 40px; padding: 6px 10px; border-radius: 6px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); font-size: 14px;">
                <i class="bi bi-box-arrow-left me-1"></i> Salir
            </a>

            <div class="col-md-12">

                <div class="p-3 rounded bg-white shadow-sm text-center">
                    <img src="../assets/nba.jpg" alt="NBA Logo" width="175" height="100">
                </div>


                <div class="container mt-4">
                    <h2 class="text-center" style="color: #003197;">Buscador</h2>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-flex justify-content-center">
                        <div class="input-group me-2">
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre">
                        </div>
                        <div class="input-group me-2">
                            <input type="text" class="form-control" name="apellido" placeholder="Apellido">
                        </div>
                        <button type="submit" name="buscar" class="btn text-white" style="background-color: #003197;">Buscar</button>
                    </form>




                    <?php
                    if (is_array($resultado)):
                    ?>
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
                                        <th>Id team</th>
                                        <th>Favorito</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($resultado['data'] as $jugador => $datos):

                                    ?>
                                        <form action="" method="POST" class="favorito">

                                            <tr>
                                                <td hidden> <?php echo "<input type='hidden' name='playerId' value=\"" . $datos['id'] . "\" />";
                                                            ?>
                                                </td>
                                                <td><?php
                                                    echo "<input type='hidden' name='first_name' value=\"" . $datos['first_name'] . "\" />";
                                                    echo $datos['first_name'];
                                                    ?></td>
                                                <td><?php
                                                    echo "<input type='hidden' name='last_name' value=\"" . $datos['last_name'] . "\" />";
                                                    echo $datos['last_name'];
                                                    ?></td>
                                                <td><?php
                                                    echo "<input type='hidden' name='position' value=\"" . $datos['position'] . "\" />";
                                                    echo $datos['position'];
                                                    ?></td>
                                                <td><?php
                                                    $altura = $datos['height'];
                                                    $conversion = explode("-", $altura);
                                                    $pie = intval($conversion[0]);
                                                    $pulgada = intval($conversion[1]);
                                                    $pie = $pie * 0.3048;
                                                    $pulgada = $pulgada * 0.0254;
                                                    $calculoAltura = $pie + $pulgada;
                                                    $calculoAltura = round($calculoAltura, 2);
                                                    echo "<input type='hidden' name='altura' value=\"$calculoAltura\" />";
                                                    echo $calculoAltura . 'm';
                                                    ?>

                                                </td>
                                                <td><?php
                                                    $peso = $datos['weight'];
                                                    $peso = intval($peso);
                                                    $calculoPeso = $peso * 0.453592;
                                                    $calculoPeso = round($calculoPeso, 2);
                                                    echo "<input type='hidden' name='peso' value=\"$calculoPeso\" />";
                                                    echo $calculoPeso . 'Kg';

                                                    ?></td>
                                                <td><?php
                                                    echo "<input type='hidden' name='numeroJersey' value=\"" . $datos['jersey_number'] . "\" />";
                                                    echo $datos['jersey_number'];
                                                    ?></td>
                                                <td><?php
                                                    echo "<input type='hidden' name='college' value=\"" . $datos['college'] . "\" />";
                                                    echo $datos['college'];
                                                    ?></td>
                                                <td><?php
                                                    echo "<input type='hidden' name='country' value=\"" . $datos['country'] . "\" />";
                                                    echo $datos['country'];
                                                    ?></td>
                                                <td><?php
                                                    echo "<input type='hidden' name='draftYear' value=\"" . $datos['draft_year'] . "\" />";
                                                    echo $datos['draft_year'];
                                                    ?></td>
                                                <td><?php
                                                    echo "<input type='hidden' name='draftRound' value=\"" . $datos['draft_round'] . "\" />";
                                                    echo $datos['draft_round'];
                                                    ?></td>
                                                <td><?php
                                                    echo "<input type='hidden' name='draftNumber' value=\"" . $datos['draft_number'] . "\" />";
                                                    echo $datos['draft_number'];
                                                    ?></td>
                                                <td><input type="hidden" name="idTeam" value="<?php echo $datos['team']['id']; ?>"><?php echo $datos['team']['id']; ?></td>
                                                <td>
                                                    <button type="submit" name="favorito" class="btn btn-primary">Favorito</button>
                                                </td>
                                            </tr>
                                        </form>
                                    <?php

                                    endforeach;
                                    ?>

                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    <?php

                    elseif (isset($_POST['buscar'])):
    ?>
        <div class="container mt-4">
            <div class="alert alert-danger" role="alert">
                <?php echo $resultado; ?>
            </div>
        </div>
    <?php

                    endif;
    ?>
</body>
<script>
 
    $(document).on('submit', '.favorito', function(event) {
        event.preventDefault();
        let datos = $(this).serialize(); // Obtiene datos del formulario asociado
        console.log("Datos enviados:", datos); // Verifica si playerId está presente

        console.log("Formulario interceptado por AJAX");
        console.log("Datos serializados:", datos);

        $.ajax({
            url: 'añadirJugador.php',
            type: 'POST',
            dataType: 'json',
            data: datos,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: "¡Éxito!",
                        text: "Jugador añadido a favoritos correctamente",
                        icon: "success",
                        confirmButtonText: "OK"
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: response.error || "Ya lo tienes como favorito",
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