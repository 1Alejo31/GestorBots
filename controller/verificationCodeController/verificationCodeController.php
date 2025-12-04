<?php

require_once '../../model/verificationCodeModel/VerificationCodeModel.php';

session_start();

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Verificar autenticación
if (!isset($_SESSION['K_US'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

try {
    $userId = $_SESSION['K_US'];
    
    $model = new VerificationCodeModel();
    $result = $model->getVerificationCodes($userId);
    
    if ($result['status'] == 0) {
        echo json_encode([
            'success' => true,
            'message' => $result['message'],
            'codes' => $result['codes']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $result['message']
        ]);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error interno del servidor: ' . $e->getMessage()
    ]);
}