<?php
require_once '../../model/register/register_user_model.php';

class RegisterUsersController extends RegisterUserModel
{
    private $registerUserModel;

    public function __construct()
    {
        $this->registerUserModel = new RegisterUserModel();
    }

    public function registerUser($primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $fechaNacimiento, $tipoDocumento, $documento, $celular, $email, $password, $tipoUsuario, $tipoServicio, $nombreEmpresa, $nitEmpresa, $direccionEmpresa, $telefonoMovil, $urlPagina)
    {
        $statusSave = $this->registerUserModel->saveUser(
            $primerNombre,
            $segundoNombre,
            $primerApellido,
            $segundoApellido,
            $fechaNacimiento,
            $tipoDocumento,
            $documento,
            $celular,
            $email,
            $password,
            $tipoUsuario,
            $tipoServicio,
            $nombreEmpresa,
            $nitEmpresa,
            $direccionEmpresa,
            $telefonoMovil,
            $urlPagina
        );

        if (isset($statusSave)) {
            $response = [
                'status' => $statusSave['status'],
                'message' => $statusSave['message']
            ];
            return $response;
        } else {
            $response = [
                'status' => '1',
                'message' => 'Error en la ejecución del proceso'
            ];
            return $response;
        }
    }
}

#if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new RegisterUsersController();
    $data = json_decode(file_get_contents('php://input'), true);

    // Sanitizar todos los datos de entrada
    $primerNombre = htmlspecialchars($data['primer_nombre'] ?? '', ENT_QUOTES, 'UTF-8');
    $segundoNombre = htmlspecialchars($data['segundo_nombre'] ?? '', ENT_QUOTES, 'UTF-8');
    $primerApellido = htmlspecialchars($data['primer_apellido'] ?? '', ENT_QUOTES, 'UTF-8');
    $segundoApellido = htmlspecialchars($data['segundo_apellido'] ?? '', ENT_QUOTES, 'UTF-8');
    $fechaNacimiento = htmlspecialchars($data['fecha_nacimiento'] ?? '', ENT_QUOTES, 'UTF-8');
    $tipoDocumento = htmlspecialchars($data['tipo_documento'] ?? '', ENT_QUOTES, 'UTF-8');
    $documento = htmlspecialchars($data['documento'] ?? '', ENT_QUOTES, 'UTF-8');
    $celular = htmlspecialchars($data['celular'] ?? '', ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($data['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($data['password'] ?? '', ENT_QUOTES, 'UTF-8');
    $tipoUsuario = htmlspecialchars($data['tipo_usuario'] ?? '', ENT_QUOTES, 'UTF-8');
    $tipoServicio = htmlspecialchars($data['tipo_servicio'] ?? '', ENT_QUOTES, 'UTF-8');
    $nombreEmpresa = htmlspecialchars($data['nombre_empresa'] ?? '', ENT_QUOTES, 'UTF-8');
    $nitEmpresa = htmlspecialchars($data['nit_empresa'] ?? '', ENT_QUOTES, 'UTF-8');
    $direccionEmpresa = htmlspecialchars($data['direccion_empresa'] ?? '', ENT_QUOTES, 'UTF-8');
    $telefonoMovil = htmlspecialchars($data['telefono_movil'] ?? '', ENT_QUOTES, 'UTF-8');
    $urlPagina = htmlspecialchars($data['url_pagina'] ?? '', ENT_QUOTES, 'UTF-8');

    // Validar campos obligatorios
    if (empty($primerNombre)) {
        $response = ['status' => '1', 'message' => 'El campo primer_nombre es obligatorio'];
    } elseif (empty($primerApellido)) {
        $response = ['status' => '1', 'message' => 'El campo primer_apellido es obligatorio'];
    } elseif (empty($fechaNacimiento)) {
        $response = ['status' => '1', 'message' => 'El campo fecha_nacimiento es obligatorio'];
    } elseif (empty($tipoDocumento)) {
        $response = ['status' => '1', 'message' => 'El campo tipo_documento es obligatorio'];
    } elseif (empty($documento)) {
        $response = ['status' => '1', 'message' => 'El campo documento es obligatorio'];
    } elseif (empty($celular)) {
        $response = ['status' => '1', 'message' => 'El campo celular es obligatorio'];
    } elseif (empty($email)) {
        $response = ['status' => '1', 'message' => 'El campo email es obligatorio'];
    } elseif (empty($password)) {
        $response = ['status' => '1', 'message' => 'El campo password es obligatorio'];
    } elseif (empty($tipoUsuario)) {
        $response = ['status' => '1', 'message' => 'El campo tipo_usuario es obligatorio'];
    } elseif (empty($tipoServicio)) {
        $response = ['status' => '1', 'message' => 'El campo tipo_servicio es obligatorio'];
    } elseif (empty($nombreEmpresa)) {
        $response = ['status' => '1', 'message' => 'El campo nombre_empresa es obligatorio'];
    } elseif (empty($nitEmpresa)) {
        $response = ['status' => '1', 'message' => 'El campo nit_empresa es obligatorio'];
    } elseif (empty($direccionEmpresa)) {
        $response = ['status' => '1', 'message' => 'El campo direccion_empresa es obligatorio'];
    } elseif (empty($telefonoMovil)) {
        $response = ['status' => '1', 'message' => 'El campo telefono_movil es obligatorio'];
    } else {
        $response = $controller->registerUser(
            $primerNombre,
            $segundoNombre,
            $primerApellido,
            $segundoApellido,
            $fechaNacimiento,
            $tipoDocumento,
            $documento,
            $celular,
            $email,
            $password,
            $tipoUsuario,
            $tipoServicio,
            $nombreEmpresa,
            $nitEmpresa,
            $direccionEmpresa,
            $telefonoMovil,
            $urlPagina
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
#}
?>
