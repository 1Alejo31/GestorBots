<?php
require '../../model/conection/conection.php';

class ExcelModel extends ConectionDb {
    private $connection;
    private $conection;
    
    public function __construct() {
        $this->connection = self::conectionDb();
    }
    
    public function saveExcelData($excelData, $userId) {
        try {
            $conection = $this->connection;
        
            if (!$conection) {
                return [
                    'status' => 'error',
                    'message' => 'Error de conexión a la base de datos'
                ];
            }
            
            // Log para ver los datos originales
            error_log("Datos originales: " . json_encode($excelData));
            
            // COMENTAR O ELIMINAR ESTAS LÍNEAS
            // Remover la primera fila (encabezados)
            // if (count($excelData) > 0) {
            //     array_shift($excelData);
            // }
            
            // Log para ver los datos después de remover encabezados
            error_log("Datos a procesar: " . json_encode($excelData));
            
            if (empty($excelData)) {
                return [
                    'status' => 'error',
                    'message' => 'No hay datos para guardar después de remover los encabezados'
                ];
            }
            
            // Convertir datos a JSON
            $jsonData = json_encode($excelData);
            error_log("JSON a enviar: " . $jsonData);
            
            // Preparar la llamada al procedimiento almacenado
            $stmt = $conection->prepare("CALL DB_GENERAL.SAVE_EXCEL_DATA(?, ?, @v_codigo, @v_resultado)");
            $stmt->bindParam(1, $jsonData, PDO::PARAM_STR);
            $stmt->bindParam(2, $userId, PDO::PARAM_INT);
            
            $stmt->execute();
            
            // Obtener los valores de salida
            $result = $conection->query("SELECT @v_codigo as codigo, @v_resultado as resultado");
            $output = $result->fetch(PDO::FETCH_ASSOC);
            
            // Log para debugging
            error_log("Procedure Output - Codigo: " . $output['codigo'] . ", Resultado: " . $output['resultado']);
            
            if ($output['codigo'] == 1) {
                return [
                    'status' => 'success',
                    'message' => $output['resultado']
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => $output['resultado'] ?: 'Error desconocido en el procedimiento'
                ];
            }
            
        } catch (Exception $e) {
            // Log del error completo
            error_log("Excel Model Error: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            
            return [
                'status' => 'error',
                'message' => 'Error al guardar los datos: ' . $e->getMessage()
            ];
        } finally {
            if (isset($conection)) {
                $conection = null;
            }
        }
    }
}
?>