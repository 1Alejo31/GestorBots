<?php
session_start();

require_once '../../model/phoneUpdateModel/phoneUpdateModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

if (!isset($_SESSION['K_US'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Usuario no autenticado'
    ]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['phoneNumber']) || empty(trim($input['phoneNumber']))) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Número de teléfono requerido'
    ]);
    exit;
}

$phoneNumber = trim($input['phoneNumber']);
$userId = $_SESSION['K_US'];

// Validar formato del número (solo números, máximo 10 dígitos)
if (!preg_match('/^[0-9]{1,10}$/', $phoneNumber)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'El número debe contener solo dígitos y máximo 10 caracteres'
    ]);
    exit;
}

try {
    $phoneUpdateModel = new PhoneUpdateModel();
    $result = $phoneUpdateModel->updatePhoneNumber($userId, $phoneNumber);
    
    if ($result['success']) {
        echo json_encode([
            'success' => true,
            'message' => $result['message']
        ]);
    } else {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $result['message']
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error interno del servidor'
    ]);
}
?>