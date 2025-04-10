<?php 

require_once __DIR__ . '/../vendor/autoload.php';
 use Oianeis\ApiNba\Conexion;
 use Oianeis\ApiNba\Login;



//use oianeis\ApiNba\Conexion;

//echo "<pre>";
//print_r(get_declared_classes());
//echo "</pre>";
//exit;

function campoNombre($nombre){
    $userName = strtolower(trim($nombre));
    return !empty($userName);
}

function campoPass($password){
    $password = trim($password);
    return !empty($password);
}

function comprobacionUsuario($nombre, $password){


    $conexion = new Conexion(); 
    $logUsuario = new Login($conexion); 
    return $logUsuario->comprobarUsuario($nombre, $password); // Suponiendo que devuelve un array si es válido
}

function validacion($datos){
    $respuesta = [];

    if(!campoNombre($datos['nombre'])){
        $respuesta['errName'][] = 'El campo nombre no puede estar vacío';
    }
    if(!campoPass($datos['password'])){
        $respuesta['errPass'][] = 'El campo contraseña no puede estar vacío';
    }

    if(empty($respuesta)){
       
        $user = comprobacionUsuario($datos['nombre'], $datos['password']);

      if(is_array($user)){
        session_start();
        $_SESSION['usuario'] = $user;
        return ['success' => true, 'usuario' => $user];
    
    
        } else {
            $respuesta['errUsuario'][] = 'Nombre o contraseña incorrectos';
        }
    }

    return $respuesta;
}


header('Content-Type: application/json');
echo json_encode(validacion($_POST));
