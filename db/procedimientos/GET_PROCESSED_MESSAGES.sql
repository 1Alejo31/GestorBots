DELIMITER //

DROP PROCEDURE IF EXISTS DB_GENERAL.GET_PROCESSED_MESSAGES//

CREATE PROCEDURE `DB_GENERAL`.`GET_PROCESSED_MESSAGES`(
    IN V_USER_ID INT,
    OUT V_CODIGO INT,
    OUT V_RESULTADO TEXT
)
BEGIN
    DECLARE v_count INT DEFAULT 0;
    DECLARE v_json_result TEXT DEFAULT '';
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        SET V_CODIGO = 500;
        SET V_RESULTADO = 'Error en la base de datos al obtener los mensajes procesados';
        ROLLBACK;
    END;
    
    START TRANSACTION;
    
    -- Verificar si existen registros para el usuario
    SELECT COUNT(*) INTO v_count 
    FROM tbl_gestor_mensaje 
    WHERE GS_USUARIO_CREACION = V_USER_ID;
    
    IF v_count = 0 THEN
        SET V_CODIGO = 1;
        SET V_RESULTADO = 'No se encontraron mensajes procesados para este usuario';
    ELSE
        -- Construir el resultado en formato JSON
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'nombre_empresa', GS_DETALLE1,
                'mensaje', GS_DETALLE16,
                'fecha_procesamiento', SUBSTRING_INDEX(
                    SUBSTRING_INDEX(GS_DETALLE16, ' -', 1),
                    'PROCESADO_', -1
                ),
                'estado', GS_ESTATUS
            )
        ) INTO v_json_result
        FROM tbl_gestor_mensaje 
        WHERE GS_USUARIO_CREACION = V_USER_ID;
        
        SET V_CODIGO = 0;
        SET V_RESULTADO = IFNULL(v_json_result, '[]');
    END IF;
    
    COMMIT;
END //

DELIMITER ;