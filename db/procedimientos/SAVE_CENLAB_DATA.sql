DELIMITER //

CREATE PROCEDURE SAVE_CENLAB_DATA(
    IN V_EMPRESA VARCHAR(255),
    IN V_NOMBRE VARCHAR(255),
    IN V_DOCUMENTO VARCHAR(100),
    IN V_TELEFONO VARCHAR(20),
    IN V_TIPO VARCHAR(255),
    IN V_RECOMENDACIONES TEXT,
    IN V_CORREO VARCHAR(255),
    IN V_CORREO_COPIA VARCHAR(255),
    IN V_CORREO_COPIA_S VARCHAR(255),
    IN V_CORREO_COPIA_T VARCHAR(255),
    IN V_EXAMENES TEXT,
    IN V_FECHA VARCHAR(255),
    IN V_CIUDAD VARCHAR(255),
    IN V_LUGAR VARCHAR(255),
    IN V_USUARIO_CREACION VARCHAR(100),
    OUT V_CODIGO VARCHAR(10),
    OUT V_RESULTADO VARCHAR(500)
)
BEGIN
    DECLARE EMPRESA INT;

    START TRANSACTION;

    SELECT EM_CODIGO INTO EMPRESA
    FROM DB_GENERAL.TBL_EMPRESA
    WHERE EM_DETALLE = V_USUARIO_CREACION
    AND EM_ESTATUS = 'ACTIVO'
    LIMIT 1;

    IF EMPRESA IS NULL THEN
        SET V_CODIGO = '1';
        SET V_RESULTADO = 'No se encontró la empresa asociada al usuario';
    END IF;
    
    INSERT INTO DB_GENERAL.TBL_GESTOR_MENSAJE (
        GS_DETALLE,
        GS_DETALLE1,
        GS_DETALLE2,
        GS_DETALLE3,
        GS_DETALLE4,
        GS_DETALLE5,
        GS_DETALLE6,
        GS_DETALLE7,
        GS_DETALLE8,
        GS_DETALLE9,
        GS_DETALLE10,
        GS_DETALLE11,
        GS_DETALLE12,
        GS_DETALLE13,
        GS_DETALLE14,
        GS_USUARIO_CREACION,
        GS_ESTATUS
    ) VALUES (
        'PUBLICIDAD-E',
        V_EMPRESA,
        V_NOMBRE,
        V_DOCUMENTO,
        V_TELEFONO,
        V_TIPO,
        V_RECOMENDACIONES,
        V_CORREO,
        V_CORREO_COPIA,
        V_CORREO_COPIA_S,
        V_CORREO_COPIA_T,
        V_EXAMENES,
        V_FECHA,
        V_CIUDAD,
        V_LUGAR,
        EMPRESA,
        'SIN GESTION'
    );
    
    COMMIT;
    
    SET V_CODIGO = '0';
    SET V_RESULTADO = 'Datos guardados exitosamente';

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET V_CODIGO = '1';
        SET V_RESULTADO = 'Error al guardar los datos en la base de datos';
    END;        
END //

DELIMITER ;



$empresa->Aguisu
$nombre->Alejo Gonzalez
$documento->1033801656
$telefono->3024019406
$tipo->CARDIOLOGIA
$recomendaciones->Presentarse en ayunas
$correo->alejo.g31@hotmail.com
$correo_copia->
$correo_copia_s->
$correo_copia_t->
$examenes->CARDIORESPERIATORIO
$fecha->2025-09-18 08: 38
$ciudad->Bogotá
$lugar->CL 41
$user->2
