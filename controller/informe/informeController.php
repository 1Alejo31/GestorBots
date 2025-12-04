<?php
session_start();
header('Content-Type: application/json');

require_once '../../model/informe/informeModel.php';

try {
    // Verificar autenticación
    if (!isset($_SESSION['K_US'])) {
        echo json_encode([
            'status' => '401',
            'message' => 'Usuario no autenticado'
        ]);
        exit;
    }

    $userId = $_SESSION['K_US'];
    
    // Instanciar modelo
    $informeModel = new InformeModel();
    
    // Obtener los informes
    $result = $informeModel->getProcessedMessages($userId);
    
    echo json_encode($result);
    
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error interno del servidor: ' . $e->getMessage()
    ]);
}
?>