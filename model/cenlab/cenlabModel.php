<?php
require '../../model/conection/conection.php';

class CenlabModel extends ConectionDb {
    
    private $conection;
    
    public function __construct() {
        $this->conection = self::conectionDb();
    }
    
    public function saveCenlabData(
        $empresa, $nombre, $documento, $telefono, $tipo,
        $recomendaciones, $correo, $correo_copia, $correo_copia_s,
        $correo_copia_t, $examenes, $fecha, $ciudad, $lugar
    ) {
        $conection = $this->conection;
        
        if ($conection) {
            try {
                // Preparar llamada al procedimiento almacenado
                $stmt = $conection->prepare(
                    "CALL DB_GENERAL.SAVE_CENLAB_DATA(
                        :V_EMPRESA, :V_NOMBRE, :V_DOCUMENTO, :V_TELEFONO, :V_TIPO,
                        :V_RECOMENDACIONES, :V_CORREO, :V_CORREO_COPIA, :V_CORREO_COPIA_S,
                        :V_CORREO_COPIA_T, :V_EXAMENES, :V_FECHA, :V_CIUDAD, :V_LUGAR,
                        :V_USUARIO_CREACION, @V_CODIGO, @V_RESULTADO
                    )"
                );
                
                $user = $_SESSION['K_US'];
                
                $stmt->bindParam(':V_EMPRESA', $empresa);
                $stmt->bindParam(':V_NOMBRE', $nombre);
                $stmt->bindParam(':V_DOCUMENTO', $documento);
                $stmt->bindParam(':V_TELEFONO', $telefono);
                $stmt->bindParam(':V_TIPO', $tipo);
                $stmt->bindParam(':V_RECOMENDACIONES', $recomendaciones);
                $stmt->bindParam(':V_CORREO', $correo);
                $stmt->bindParam(':V_CORREO_COPIA', $correo_copia);
                $stmt->bindParam(':V_CORREO_COPIA_S', $correo_copia_s);
                $stmt->bindParam(':V_CORREO_COPIA_T', $correo_copia_t);
                $stmt->bindParam(':V_EXAMENES', $examenes);
                $stmt->bindParam(':V_FECHA', $fecha);
                $stmt->bindParam(':V_CIUDAD', $ciudad);
                $stmt->bindParam(':V_LUGAR', $lugar);
                $stmt->bindParam(':V_USUARIO_CREACION', $user);
                
                $stmt->execute();
                
                $query = "SELECT @V_CODIGO AS codigo, @V_RESULTADO AS resultado";
                $out = $conection->query($query)->fetch(PDO::FETCH_ASSOC);
                
                if ($out['codigo'] == "0") {
                    $responseArray = [
                        "status" => $out['codigo'],
                        "message" => $out['resultado']
                    ];
                } else {
                    $responseArray = [
                        "status" => $out['codigo'],
                        "message" => $out['resultado']
                    ];
                }
                
            } catch (PDOException $e) {
                $responseArray = [
                    "status" => "500",
                    "message" => "Error en base de datos: " . $e->getMessage()
                ];
            }
        } else {
            $responseArray = [
                "status" => "500",
                "message" => "Error de conexión a la base de datos"
            ];
        }
        
        return $responseArray;
    }
}
?>