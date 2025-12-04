<?php
header('Content-Type: application/json');

require '../../model/login/loginModel.php';
require '../../controller/gestorSession/gestorSession.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['user']) && isset($data['password'])) {

    $login = new LoginUsuario();

    $user = htmlspecialchars($data['user'], ENT_QUOTES, 'UTF-8');
    $pass = htmlspecialchars($data['password'], ENT_QUOTES, 'UTF-8');

    $consulta = $login->verificarUsuraio($user, $pass);

    if (isset($consulta)) {

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
        }

        if ($consulta['status'] == 1) {
            $response = [
                'status' => $consulta['status'],
                'message' => $consulta['message'],
            ];
        }

        if ($consulta['status'] == 2) {
            $response = [
                'status' => $consulta['status'],
                'message' => 'Usuario duplicado, comunicarse con el administrador del sistema',
            ];
        }
    } else {
        $response = [
            'status' => '4',
            'message' => 'Se presento un error no identificado!',
        ];
    }

    echo json_encode($response);
} else {
    $response = [
        'error' => 'Datos no recibidos correctamente'
    ];
    echo json_encode($response);
}
