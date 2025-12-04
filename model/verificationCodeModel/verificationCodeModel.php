<?php

require '../../model/conection/conection.php';

class VerificationCodeModel extends ConectionDb
{
    public function getVerificationCodes($userId)
    {
        $conection = self::conectionDb();
        $responseArray = [];

        if ($conection) {
            try {
                $stmt = $conection->prepare("CALL GET_VERIFICATION_CODES(:V_USER_ID, @V_CODIGO, @V_RESULTADO)");
                $stmt->bindParam(':V_USER_ID', $userId, PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();

                $query = "SELECT @V_CODIGO AS codigo, @V_RESULTADO AS resultado";
                $out = $conection->query($query)->fetch(PDO::FETCH_ASSOC);

                if ($out['codigo'] == 0) {
                    // Separar los códigos por comas
                    $codes = explode(',', $out['resultado']);
                    
                    // Asegurar que tenemos exactamente 8 códigos
                    $codes = array_pad($codes, 8, '');
                    $codes = array_slice($codes, 0, 8);
                    
                    $responseArray = [
                        "status" => 0,
                        "message" => "Códigos obtenidos exitosamente",
                        "codes" => [
                            "code1" => trim($codes[0]),
                            "code2" => trim($codes[1]),
                            "code3" => trim($codes[2]),
                            "code4" => trim($codes[3]),
                            "code6" => trim($codes[4]),
                            "code7" => trim($codes[5]),
                            "code8" => trim($codes[6]),
                            "code9" => trim($codes[7])
                        ]
                    ];
                } elseif ($out['codigo'] == 1) {
                    $responseArray = [
                        "status" => 1,
                        "message" => "Usuario no encontrado"
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