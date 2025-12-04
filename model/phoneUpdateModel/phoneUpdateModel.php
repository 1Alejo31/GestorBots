<?php

require '../../model/conection/conection.php';

class PhoneUpdateModel extends ConectionDb
{
    public function updatePhoneNumber($userId, $phoneNumber)
    {
        $conection = self::conectionDb();
        $responseArray = [];

        if ($conection) {
            try {
                $stmt = $conection->prepare("CALL UPDATE_PHONE_NUMBER(:V_USER_ID, :V_PHONE_NUMBER, @V_CODIGO, @V_RESULTADO)");
                $stmt->bindParam(':V_USER_ID', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':V_PHONE_NUMBER', $phoneNumber, PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor();

                $query = "SELECT @V_CODIGO AS codigo, @V_RESULTADO AS resultado";
                $out = $conection->query($query)->fetch(PDO::FETCH_ASSOC);

                if ($out['codigo'] == 0) {
                    $responseArray = [
                        "status" => $out['codigo'],
                        "message" => $out['resultado'],
                        "success" => true
                    ];
                } elseif ($out['codigo'] == 1) {
                    $responseArray = [
                        "status" => 1,
                        "message" => "Usuario no encontrado en tabla empresa",
                        "success" => false
                    ];
                } elseif ($out['codigo'] == 2) {
                    $responseArray = [
                        "status" => 2,
                        "message" => "Error: múltiples registros encontrados",
                        "success" => false
                    ];
                } else {
                    $responseArray = [
                        "status" => 99,
                        "message" => "Error inesperado",
                        "success" => false
                    ];
                }

                ConectionDb::cerrarConexion();
            } catch (PDOException $e) {
                $responseArray = [
                    "status" => 500,
                    "message" => "Error en base de datos: " . $e->getMessage(),
                    "success" => false
                ];
            }
        } else {
            $responseArray = [
                "status" => 500,
                "message" => "Error de conexión",
                "success" => false
            ];
        }

        return $responseArray;
    }
}
?>