DELIMITER //

CREATE PROCEDURE `DB_GENERAL`.`GET_VERIFICATION_CODES`(
    IN V_USER_ID INT,
    OUT V_CODIGO INT,
    OUT V_RESULTADO VARCHAR(255)
)
BEGIN
    DECLARE v_count INT DEFAULT 0;
    DECLARE v_detalle9 VARCHAR(255) DEFAULT '';
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        SET V_CODIGO = 500;
        SET V_RESULTADO = 'Error en la base de datos';
        ROLLBACK;
    END;
    
    START TRANSACTION;
    
    -- Verificar si existe el usuario
    SELECT COUNT(*) INTO v_count 
    FROM TBL_EMPRESA 
    WHERE EM_DETALLE = V_USER_ID;
    
    IF v_count = 0 THEN
        SET V_CODIGO = 1;
        SET V_RESULTADO = 'Usuario no encontrado';
    ELSEIF v_count > 1 THEN
        SET V_CODIGO = 2;
        SET V_RESULTADO = 'Múltiples registros encontrados';
    ELSE
        -- Obtener EM_DETALLE9
        SELECT EM_DETALLE9 INTO v_detalle9
        FROM TBL_EMPRESA
        WHERE EM_DETALLE = V_USER_ID
        LIMIT 1;
        
        SET V_CODIGO = 0;
        SET V_RESULTADO = IFNULL(v_detalle9, '');
    END IF;
    
    COMMIT;
END //

DELIMITER ;