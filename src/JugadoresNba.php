<?php
namespace Oianeis\ApiNba;
use PDO;
use PDOException;

class JugadoresNba extends PDO{
  
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    public function verFavoritos(){
        try{
            $sql = "SELECT * FROM favoritos ORDER BY first_name";
            $stmt=$this->conexion->prepare($sql);
            $stmt->execute();
            $favoritos=$stmt->fetchAll(PDO::FETCH_OBJ);
            return $favoritos;

        }catch(PDOException $e){
            return ['error' => 'Error en la consulta: ' . $e->getMessage()];

        }
    }
    public function existeJugador($playerId) {
        try {
            $sqlComprobacion = 'SELECT player_id FROM favoritos WHERE player_id=?';
            $stmt1 = $this->conexion->prepare($sqlComprobacion);
            $stmt1->bindValue(1, $playerId, PDO::PARAM_INT);
            $stmt1->execute();
            return $stmt1->rowCount() > 0;
        } catch (PDOException $e) {
            return ['error' => 'Error en la consulta: ' . $e->getMessage()];
        }
    }
        public function añadirFavorito($datos=[]){
            $playerId=$datos['playerId'];
            $playerId=intval($playerId);
            try{
          $sql='INSERT INTO favoritos (player_id, first_name, last_name, position, height, weight, numeroJersey, college, country, draft_year, draft_round, draft_number, team) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
';
            $sqlComprobacion='SELECT player_id from favoritos where player_id=?';
         
            
          //  $stmt1=$this->conexion->prepare($sqlComprobacion);
            //$stmt1->bindparam(1,$datos['playerId']);
            //$stmt1->execute();
            $existe=$this->existeJugador($playerId);
            if($existe){
                return 'este jugador ya esta añadido a favoritos';
            }else{
          //     var_dump($datos);
             //  exit;
                $this->conexion->beginTransaction();
                $stmt2=$this->conexion->prepare($sql);
                $stmt2->bindParam(1,$datos['playerId']);
                $stmt2->bindParam(2,$datos['first_name']);
                $stmt2->bindParam(3,$datos['last_name']);
                $stmt2->bindParam(4,$datos['position']);
                $stmt2->bindParam(5,$datos['altura']);
                $stmt2->bindParam(6,$datos['peso']);
                $stmt2->bindParam(7,$datos['numeroJersey']);
                $stmt2->bindParam(8,$datos['college']);
                $stmt2->bindParam(9,$datos['country']);
                $stmt2->bindParam(10,$datos['draftYear']);
                $stmt2->bindParam(11,$datos['draftRound']);
                $stmt2->bindParam(12,$datos['draftNumber']);
                $stmt2->bindParam(13,$datos['idTeam']);
                if($stmt2->execute()){
                    $this->conexion->commit();
            
                    return true;
                } 
                else{
                     $this->conexion->rollBack();
            

                     return false;
                }


            }
            }catch(PDOException $e){
           

                return ['error' => 'Error al insertar jugador: ' . $e->getMessage()];            }
  
        }
        public function verJugador($id){
            try{
                if (is_array($id)) {
                    $id = reset($id); // Extrae el primer valor
                }
        
                $id = intval($id); // Convierte a entero

                $sql="SELECT * FROM favoritos WHERE id= ?";
            
                $stmt=$this->conexion->prepare($sql);
                $stmt->bindParam(1,$id);
                $stmt->execute();
                $jugador=$stmt->fetchAll(PDO::FETCH_OBJ);
                return $jugador[0];
            }catch(PDOException $e){
                return ['error' => 'Error al obtener el jugador: ' . $e->getMessage()];            }

            }
        

        public function borrarJugador($id){
            try{
                if (is_array($id)) {
                    $id = reset($id); // Extrae el primer valor
                }
        
                $id = intval($id); // Convierte a entero

                $sql="DELETE FROM favoritos WHERE id= ?";
                $this->conexion->beginTransaction();
                $stmt=$this->conexion->prepare($sql);
                $stmt->bindParam(1,$id);
                if($stmt->execute()){
                    $this->conexion->commit();
           
                    return true;
                } 
                else{
                     $this->conexion->rollBack();

                     return false;
                }
            }catch(PDOException $e){
                return ['error' => 'Error al borrar jugador: ' . $e->getMessage()];            }

            }
        
  

  
 
}