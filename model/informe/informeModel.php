<?php
require '../../model/conection/conection.php';

class InformeModel extends ConectionDb
{

    private $conection;

    public function __construct()
    {
        $this->conection = self::conectionDb();
    }

    public function getProcessedMessages($userId)
    {
        $conection = $this->conection;

        if ($conection) {
            try {
                // Consulta SQL directa
                $sql = "SELECT 
                            GS_DETALLE1 AS nombre_empresa, 
                            SUBSTRING_INDEX( 
                                SUBSTRING_INDEX(GS_DETALLE16, ' -', 1), 
                                'PROCESADO_', -1 
                            ) AS fecha_procesamiento, 
                            GS_ESTATUS AS estado 
                        FROM tbl_gestor_mensaje 
                        WHERE GS_USUARIO_CREACION = ?";

                $stmt = $conection->prepare($sql);
                $userId = 5;
                $stmt->bindParam(1, $userId, PDO::PARAM_INT);
                $stmt->execute();

                // Obtener todos los resultados
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($data && count($data) > 0) {
                    return [
                        'status' => 'success',
                        'data' => $data,
                        'message' => 'Datos obtenidos correctamente'
                    ];
                } else {
                    return [
                        'status' => 'info',
                        'data' => [],
                        'message' => 'No se encontraron mensajes procesados para este usuario'
                    ];
                }
            } catch (Exception $e) {
                error_log("Informe Model Error: " . $e->getMessage());
                return [
                    'status' => 'error',
                    'data' => [],
                    'message' => 'Error al obtener los informes: ' . $e->getMessage()
                ];
            } finally {
                if (isset($conection)) {
                    $conection = null;
                }
            }
        } else {
            return [
                'status' => 'error',
                'data' => [],
                'message' => 'Error de conexión a la base de datos'
            ];
        }
    }
}
