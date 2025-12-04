<?php

require '../../model/conection/conection.php';

class SessionStatusModel extends ConectionDb
{
    public function getSessionStatus($userId)
    {
        $conection = self::conectionDb();
        $responseArray = [];

        if ($conection) {
            try {
                $stmt = $conection->prepare("CALL GET_BOT_SESSION_STATUS(:V_USER_ID, @V_CODIGO, @V_RESULTADO)");
                $stmt->bindParam(':V_USER_ID', $userId, PDO::PARAM_INT);
                $stmt->execute();

                $resultadoEstado = $stmt->fetch(PDO::FETCH_ASSOC);
                $stmt->closeCursor();

                $query = "SELECT @V_CODIGO AS codigo, @V_RESULTADO AS resultado";
                $out = $conection->query($query)->fetch(PDO::FETCH_ASSOC);

                if ($out['codigo'] == 0) {
                    $responseArray = [
                        "status" => $out['codigo'],
                        "message" => $out['resultado'],
                        "empresa_id" => $resultadoEstado['ID'],
                        "estado_sesion" => $resultadoEstado['ESTADO_SESION']
                    ];
                } elseif ($out['codigo'] == 1) {
                    $responseArray = [
                        "status" => 1,
                        "message" => "Empresa no encontrada"
                    ];
                } elseif ($out['codigo'] == 2) {
                    $responseArray = [
                        "status" => 2,
                        "message" => "Error: múltiples registros encontrados"
                    ];
                } else {
                    $responseArray = [
                        "status" => 99,
                        "message" => "Error inesperado"
                    ];
                }

                ConectionDb::cerrarConexion();
            } catch (PDOException $e) {
                $responseArray = [
                    "status" => 500,
                    "message" => "Error en base de datos: " . $e->getMessage()
                ];
            }
        } else {
            $responseArray = [
                "status" => 500,
                "message" => "Error de conexión"
            ];
        }

        return $responseArray;
    }
}