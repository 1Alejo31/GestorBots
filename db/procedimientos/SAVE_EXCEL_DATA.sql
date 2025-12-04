    DELIMITER //

    DROP PROCEDURE IF EXISTS DB_GENERAL.SAVE_EXCEL_DATA//

    CREATE OR REPLACE PROCEDURE DB_GENERAL.SAVE_EXCEL_DATA(
        IN V_DATOS LONGTEXT,
        IN V_USUARIO_CREACION VARCHAR(50),
        OUT V_CODIGO INT,
        OUT V_RESULTADO VARCHAR(500)
    )
    BEGIN
        DECLARE v_json_length INT DEFAULT 0;
        DECLARE v_i INT DEFAULT 1;
        DECLARE v_row_json TEXT DEFAULT '';
        DECLARE v_col0 TEXT DEFAULT '';
        DECLARE v_col1 TEXT DEFAULT '';
        DECLARE v_col2 TEXT DEFAULT '';
        DECLARE v_col3 TEXT DEFAULT '';
        DECLARE v_col4 TEXT DEFAULT '';
        DECLARE v_col5 TEXT DEFAULT '';
        DECLARE v_col6 TEXT DEFAULT '';
        DECLARE v_col7 TEXT DEFAULT '';
        DECLARE v_col8 TEXT DEFAULT '';
        DECLARE v_col9 TEXT DEFAULT '';
        DECLARE v_col10 TEXT DEFAULT '';
        DECLARE v_col11 TEXT DEFAULT '';
        DECLARE v_col12 TEXT DEFAULT '';
        DECLARE v_col13 TEXT DEFAULT '';
        DECLARE v_col14 TEXT DEFAULT '';
        DECLARE v_rows_inserted INT DEFAULT 0;
        DECLARE v_continue INT DEFAULT 1;
        
        DECLARE EXIT HANDLER FOR SQLEXCEPTION
        BEGIN
            ROLLBACK;
            SET V_CODIGO = -1;
            SET V_RESULTADO = 'Error al guardar los datos del Excel';
        END;

        START TRANSACTION;
        
        SET V_CODIGO = 0;
        SET V_RESULTADO = 'Iniciando proceso';
        
        -- Verificar si V_DATOS es válido
        IF V_DATOS IS NULL OR V_DATOS = '' THEN
            SET V_CODIGO = 0;
            SET V_RESULTADO = 'No hay datos para procesar';
            COMMIT;
        ELSE
        
            -- Obtener la cantidad de elementos en el array JSON
            SET v_json_length = JSON_LENGTH(V_DATOS);
            
            -- Si hay menos de 2 elementos (solo encabezados o vacío), salir
            IF v_json_length IS NULL OR v_json_length <= 1 THEN
                SET V_CODIGO = 0;
                SET V_RESULTADO = 'No hay datos para procesar después de los encabezados';
                COMMIT;
            ELSE
                -- Procesar cada fila empezando desde índice 1 (saltar encabezados en índice 0)
                SET v_i = 0;
                
                WHILE v_i < v_json_length AND v_continue = 1 DO
                    -- Extraer la fila actual
                    SET v_row_json = JSON_EXTRACT(V_DATOS, CONCAT('$[', v_i, ']'));
                    
                    IF v_row_json IS NOT NULL THEN
                        -- Extraer cada columna de la fila (15 columnas: v_col0 a v_col14)
                        SET v_col0 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[0]')), '');
                        SET v_col1 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[1]')), '');
                        SET v_col2 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[2]')), '');
                        SET v_col3 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[3]')), '');
                        SET v_col4 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[4]')), '');
                        SET v_col5 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[5]')), '');
                        SET v_col6 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[6]')), '');
                        SET v_col7 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[7]')), '');
                        SET v_col8 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[8]')), '');
                        SET v_col9 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[9]')), '');
                        SET v_col10 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[10]')), '');
                        SET v_col11 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[11]')), '');
                        
                        -- Convertir v_col11 de número serial de Excel a fecha MySQL con hora (para GS_DETALLE12)
                        IF v_col11 REGEXP '^[0-9]+(\.[0-9]+)?$' AND v_col11 != '' THEN
                            SET v_col11 = DATE_FORMAT(
                                DATE_ADD(
                                    DATE_ADD('1900-01-01', INTERVAL (FLOOR(CAST(v_col11 AS DECIMAL(15,6))) - 2) DAY),
                                    INTERVAL (ROUND((CAST(v_col11 AS DECIMAL(15,6)) - FLOOR(CAST(v_col11 AS DECIMAL(15,6)))) * 86400)) SECOND
                                ), 
                                '%Y-%m-%d %H:%i:%s'
                            );
                        END IF;
                        
                        SET v_col12 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[12]')), '');
                        SET v_col13 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[13]')), '');
                        SET v_col14 = COALESCE(JSON_UNQUOTE(JSON_EXTRACT(v_row_json, '$[14]')), '');
                        
                        -- Insertar solo si la primera columna tiene datos válidos
                        IF v_col0 IS NOT NULL AND v_col0 != '' AND v_col0 != 'null' THEN
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
                                GS_DETALLE15,
                                GS_USUARIO_CREACION, 
                                GS_ESTATUS
                            ) VALUES (
                                'PUBLICIDAD-E ',
                                v_col0,
                                v_col1,
                                v_col2,
                                v_col3,
                                v_col4,
                                v_col5,
                                v_col6,
                                v_col7,
                                v_col8,
                                v_col9,
                                v_col10,
                                v_col11,
                                v_col12,
                                v_col13,
                                v_col14,
                                V_USUARIO_CREACION,
                                'SIN GESTION'
                            );
                            
                            SET v_rows_inserted = v_rows_inserted + 1;
                        END IF;
                    END IF;
                    
                    SET v_i = v_i + 1;
                END WHILE;
                
                SET V_CODIGO = 1;
                SET V_RESULTADO = CONCAT('Datos guardados correctamente. Filas insertadas: ', v_rows_inserted);
                
                COMMIT;
            END IF;
        END IF;
    END//

    DELIMITER ;