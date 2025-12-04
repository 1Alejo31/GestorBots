<?php

require '../../model/conection/conection.php';

class LoginUsuario extends ConectionDb
{

    public function verificarUsuraio($us, $pass)
    {
        $conection = self::conectionDb();
        $responseArray = [];

        $use = EnCrypt("$us");

        $passe = EnCrypt("$pass");


        if ($conection) {
            try {
                $stmt = $conection->prepare("CALL GET_USER_VALIDADO(:V_USER, :V_PASS, @V_CODIGO, @V_RESULTADO)");
                $stmt->bindParam(':V_USER', $use);
                $stmt->bindParam(':V_PASS', $passe);
                $stmt->execute();

                $resultadoUsuario = $stmt->fetch(PDO::FETCH_ASSOC);
                $stmt->closeCursor();

                $query = "SELECT @V_CODIGO AS codigo, @V_RESULTADO AS resultado";
                $out = $conection->query($query)->fetch(PDO::FETCH_ASSOC);

                if ($out['codigo'] == 0) {

                    $name = preg_split('/\s+/', trim($resultadoUsuario['NOMBRE']));

                    $nameStr = '';
                    for ($i = 0; $i < min(4, count($name)); $i++) {
                        if ($i > 0) $nameStr .= ' ';
                        $nameStr .= DeCrypt("$name[$i]");
                    }
                    $responseArray = [
                        "status" => $out['codigo'],
                        "message" => $out['resultado'],
                        "ID_US" => $resultadoUsuario['ID_US'],
                        "P_US" => $resultadoUsuario['P_US'],
                        "NAME" => $nameStr,
                        "T_US" => $resultadoUsuario['T_US'],
                        "T_CL" => $resultadoUsuario['T_CL']
                    ];
                } elseif ($out['codigo'] == 1) {
                    $responseArray = [
                        "status" => 1,
                        "message" => "Usuario y/o contraseña incorrectos"
                    ];
                } elseif ($out['codigo'] == 2) {
                    $responseArray = [
                        "status" => 2,
                        "message" => "Existe más de un usuario con las mismas credenciales"
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
