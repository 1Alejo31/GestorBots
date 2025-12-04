<?php
session_start();
require '../../model/excel/ExcelModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido'
    ]);
    exit;
}
$userId = $_SESSION['K_US'];
try {
    // Verificar que el usuario esté autenticado
    if (!isset($_SESSION['K_US'])) {
        http_response_code(401);
        echo json_encode([
            'status' => 'error',
            'message' => 'Usuario no autenticado'
        ]);
        exit;
    }
    
    // Obtener los datos del POST
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['data']) || !is_array($input['data'])) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Datos inválidos o faltantes'
        ]);
        exit;
    }
    
    $excelData = $input['data'];
    $userId = $_SESSION['K_US'];
    
    // Validar que hay datos
    if (empty($excelData)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'No se encontraron datos para guardar'
        ]);
        exit;
    }
    
    // Crear instancia del modelo y guardar datos
    $excelModel = new ExcelModel();
    $result = $excelModel->saveExcelData($excelData, $userId);
    
    echo json_encode($result);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error interno del servidor: ' . $e->getMessage()
    ]);
}
?>