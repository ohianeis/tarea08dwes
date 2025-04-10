<?php
//namespace Oianeis\ApiNba;

namespace Oianeis\ApiNba;
use PDO;
use PDOException;

/**
 * Clase Conexion
 * 
 * Se usa para conectar con la base de datos, extiende de PDO para usar esta forma de consultas y sus métodos.
 * 
 * @author ohiane irure
 * @since 11-4-2025.
 */
class Conexion extends PDO
{

    /**
     * Constante de la direccion de la base de datos
     * 
     * @var string
     */
    private const HOST = 'localhost';

    /**
     * Constante del nombre de la base de datos
     * 
     * @var string
     */
    private const DB = 'apinba';

    /**
     * Constante del nombre del usuario de la base de datos
     * 
     * @var string
     */
    private const USER = 'root';

    /**
     * Constante de la contraseña del usuario de la base de datos
     * 
     * @var string
     */
    private const PASS = '';

    /**
     * Constante con el nombre de la fuente de datos de la conexion a la base de datos.
     * 
     * @var string
     */
    private const DSN = 'mysql:host=' . self::HOST . ';dbname=' . self::DB . ';charset=utf8mb4';

    /**
     * Exito en la conexion de la base de datos
     * 
     * @var bool
     */
    private $exitoConexion=false;

    /**
     * Constructor de la clase
     * 
     * 
     */
    public function __construct()
    {
        try {
            parent::__construct(self::DSN, self::USER, self::PASS);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->exitoConexion=true;
        } catch (PDOException $e) {
            $this->exitoConexion=false;
            echo '<p>' . $e->getMessage() . '</p>';
        }
    }

    /**
     * Se obtiene la conexion
     * 
     * @return Conexion|bool Devuelve la conexion o false.
     */
    public function getConexion()
    {
       return $this->exitoConexion ? $this : false;
    }
  
}