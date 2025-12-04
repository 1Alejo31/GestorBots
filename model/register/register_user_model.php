<?php
require '../../model/conection/conection.php';

class RegisterUserModel extends ConectionDb {
    
    private $conection;
    
    public function __construct() {
        $this->conection = self::conectionDb();
    }
    
    public function saveUser(
        $primerNombre, $segundoNombre, $primerApellido, $segundoApellido,
        $fechaNacimiento, $tipoDocumento, $documento, $celular, $email, $password,
        $tipoUsuario, $tipoServicio, $nombreEmpresa, $nitEmpresa,
        $direccionEmpresa, $telefonoMovil, $urlPagina
    ) {
        $conection = $this->conection;
        
        if ($conection) {
            try {
                // Encriptar datos sensibles si es necesario
                $primerNombre = $primerNombre;
                $primerApellido = $primerApellido;
                $email = EnCrypt($email);
                $documento = EnCrypt($documento);
                $password = password_hash($password, PASSWORD_DEFAULT);
                
                // Preparar llamada al procedimiento almacenado
                $stmt = $conection->prepare(
                    "CALL DB_GENERAL.SAVE_USER_REGISTER(
                        :V_PRIMER_NOMBRE, :V_SEGUNDO_NOMBRE, :V_PRIMER_APELLIDO, :V_SEGUNDO_APELLIDO,
                        :V_FECHA_NACIMIENTO, :V_TIPO_DOCUMENTO, :V_DOCUMENTO, :V_TELEFONO_MOVIL_U, 
                        :V_EMAIL, :V_PASSWORD, :V_TIPO_USUARIO, :V_TIPO_SERVICIO, 
                        :V_NOMBRE_EMPRESA, :V_NIT_EMPRESA, :V_DIRECCION_EMPRESA, 
                        :V_TELEFONO_MOVIL, :V_URL_PAGINA, :V_USUARIO_CREACION,
                        @V_CODIGO, @V_RESULTADO
                    )"
                );
                session_start();

                $user = $_SESSION['K_US'];

                $stmt->bindParam(':V_PRIMER_NOMBRE', $primerNombre);
                $stmt->bindParam(':V_SEGUNDO_NOMBRE', $segundoNombre);
                $stmt->bindParam(':V_PRIMER_APELLIDO', $primerApellido);
                $stmt->bindParam(':V_SEGUNDO_APELLIDO', $segundoApellido);
                $stmt->bindParam(':V_FECHA_NACIMIENTO', $fechaNacimiento);
                $stmt->bindParam(':V_TIPO_DOCUMENTO', $tipoDocumento);
                $stmt->bindParam(':V_DOCUMENTO', $documento);
                $stmt->bindParam(':V_TELEFONO_MOVIL_U', $celular);
                $stmt->bindParam(':V_EMAIL', $email);
                $stmt->bindParam(':V_PASSWORD', $password);
                $stmt->bindParam(':V_TIPO_USUARIO', $tipoUsuario);
                $stmt->bindParam(':V_TIPO_SERVICIO', $tipoServicio);
                $stmt->bindParam(':V_NOMBRE_EMPRESA', $nombreEmpresa);
                $stmt->bindParam(':V_NIT_EMPRESA', $nitEmpresa);
                $stmt->bindParam(':V_DIRECCION_EMPRESA', $direccionEmpresa);
                $stmt->bindParam(':V_TELEFONO_MOVIL', $telefonoMovil);
                $stmt->bindParam(':V_URL_PAGINA', $urlPagina);
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