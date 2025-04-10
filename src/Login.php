<?php



namespace Oianeis\ApiNba;
use PDO;
use PDOException;

/**
 * Clase Login
 * 
 * Esta clase se encarga del logueo del usuario
 * 
 * @author ohiane irure
 * @since 8-01-2025
 */
class Login{
    /**
     * Realizar conexión a la base de datos
     * 
     * @var Conexion
     */
    private $conexion;

    /**
     * Constructor de la clase
     * 
     * @param Conexion $conexion Conexion a la base de datos
     */
    public function __construct($conexion)
    {
        $this->conexion=$conexion->getConexion();
    }

    /**
     * Comprueba si existe el usuario en la base de datos para darle acceso
     * 
     * @param string $nombre Nombre del usuario.
     * @param string $pass Password proporcionado, se hash antes de comprobarlo.
     * @param string $idioma Idioma seleccionado por el usuario.
     * 
     * * @return array|string Datos del usuario si existe en la base de datos, menaje si usuario o contraseña incorrectos
     */

    public function comprobarUsuario($nombre,$pass){
        $hashPass=hash('sha256',$pass);
        if($this->conexion){
            $stmt=$this->conexion->prepare('select * from usuarios where nombre=?');
            $stmt->bindParam(1,$nombre);
        
            $stmt->execute();
            if($fila=$stmt->fetch(PDO::FETCH_OBJ)){
                if($hashPass===$fila->password){
                $usuario=[
                    'nombre'=>$fila->nombre,
                    'apellidos'=>$fila->apellidos,
                    'id'=>$fila->id, 
                ];
           
            return $usuario;
            }else{
                return 'La contraseña no es correcta';
            }
                
            }else{
                return 'El usuario no existe';
            }
        }
    }
}