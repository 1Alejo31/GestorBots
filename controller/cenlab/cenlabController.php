<?php
session_start();
header('Content-Type: application/json');

require_once '../../model/cenlab/cenlabModel.php';

#if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Verificar autenticación
        if (!isset($_SESSION['K_US'])) {
            echo json_encode([
                'status' => '401',
                'message' => 'Usuario no autenticado'
            ]);
            exit;
        }
        
        // Obtener datos del POST
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            echo json_encode([
                'status' => '400',
                'message' => 'No se recibieron datos válidos'
            ]);
            exit;
        }
        
        // Validar campos requeridos
        $requiredFields = [
            'empresa', 'nombre', 'documento', 'telefono', 'tipo',
            'recomendaciones', 'correo', 'examenes', 'fecha', 'ciudad', 'lugar'
        ];
        
        foreach ($requiredFields as $field) {
            if (empty($input[$field])) {
                echo json_encode([
                    'status' => '400',
                    'message' => "El campo {$field} es obligatorio"
                ]);
                exit;
            }
        }
        
        // Formatear fecha: reemplazar 'T' por espacio
        $fechaFormateada = str_replace('T', ' ', $input['fecha']);
        
        // Instanciar modelo y guardar datos
        $cenlabModel = new CenlabModel();
        
        $result = $cenlabModel->saveCenlabData(
            $input['empresa'],
            $input['nombre'],
            $input['documento'],
            $input['telefono'],
            $input['tipo'],
            $input['recomendaciones'],
            $input['correo'],
            $input['correo_copia'],
            $input['correo_copia_s'],
            $input['correo_copia_t'],
            $input['examenes'],
            $fechaFormateada,
            $input['ciudad'],
            $input['lugar']
        );
        
        echo json_encode($result);
        
    } catch (Exception $e) {
        echo json_encode([
            'status' => '500',
            'message' => 'Error interno del servidor: ' . $e->getMessage()
        ]);
    }
#} else {
#    echo json_encode([
#        'status' => '405',
#        'message' => 'Método no permitido'
#    ]);
#}
?>