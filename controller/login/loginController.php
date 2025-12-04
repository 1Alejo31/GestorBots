<?php
header('Content-Type: application/json');

require '../../model/login/loginModel.php';
require '../../controller/gestorSession/gestorSession.php';

$data = json_decode(file_get_contents('php://input'), true);

$response = [
    'status' => 99,
    'message' => 'Error inesperado'
];

if (isset($data['user']) && isset($data['password'])) {

    $login = new LoginUsuario();

    $user = htmlspecialchars($data['user'], ENT_QUOTES, 'UTF-8');
    $pass = htmlspecialchars($data['password'], ENT_QUOTES, 'UTF-8');

    try {
        $consulta = $login->verificarUsuraio($user, $pass);
    } catch (\Throwable $th) {
        $consulta = null;
    }

    if (is_array($consulta) && isset($consulta['status'])) {

        if ($consulta['status'] == 0) {
            session_start();
            $_SESSION['K_US'] = $consulta['ID_US'];
            $_SESSION['T_US'] = $consulta['P_US'];
            $_SESSION['N_US'] = $consulta['NAME'];
            $_SESSION['T_CL'] = $consulta['T_CL'];

            $response = [
                'status' => $consulta['status'],
                "message" => 'OK',
            ];
        } elseif ($consulta['status'] == 1) {
            $response = [
                'status' => $consulta['status'],
                'message' => $consulta['message'],
            ];
        } elseif ($consulta['status'] == 2) {
            $response = [
                'status' => $consulta['status'],
                'message' => 'Usuario duplicado, comunicarse con el administrador del sistema',
            ];
        } else {
            $response = [
                'status' => $consulta['status'],
                'message' => $consulta['message'] ?? 'Respuesta no reconocida'
            ];
        }
    } else {
        $response = [
            'status' => 500,
            'message' => 'Error de conexión o respuesta inválida del servidor'
        ];
    }

    echo json_encode($response);
} else {
    $response = [
        'error' => 'Datos no recibidos correctamente'
    ];
    echo json_encode($response);
}