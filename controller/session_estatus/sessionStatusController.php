<?php
header('Content-Type: application/json');

require '../../model/session_estatus/SessionStatusModel.php';

// Verificar si hay sesión activa
session_start();
if (!isset($_SESSION['K_US'])) {
    $response = [
        'status' => 401,
        'message' => 'No hay sesión activa'
    ];
    echo json_encode($response);
    exit;
}

// Obtener el ID del usuario desde la sesión
$userId = $_SESSION['K_US'];

$sessionStatus = new SessionStatusModel();
$consulta = $sessionStatus->getSessionStatus($userId);

if (isset($consulta)) {
    if ($consulta['status'] == 0) {
        $response = [
            'status' => $consulta['status'],
            'message' => 'OK',
            'data' => [
                'empresa_id' => $consulta['empresa_id'],
                'estado_sesion' => $consulta['estado_sesion']
            ]
        ];
    } else {
        $response = [
            'status' => $consulta['status'],
            'message' => $consulta['message']
        ];
    }
} else {
    $response = [
        'status' => 4,
        'message' => 'Se presentó un error no identificado'
    ];
}

echo json_encode($response);