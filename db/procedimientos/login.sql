    DELIMITER //
    CREATE OR REPLACE PROCEDURE DB_GENERAL.GET_USER_VALIDADO (
        IN V_USER VARCHAR(200),
        IN V_PASS VARCHAR(200),
        OUT V_CODIGO INT,
        OUT V_RESULTADO VARCHAR(200)
    )
    BEGIN
        DECLARE V_CANTIDAD INT;

        -- VALIDAR CANTIDAD DE COINCIDENCIAS
        SELECT COUNT(*) INTO V_CANTIDAD
        FROM DB_GENERAL.TBL_PERMISOS P
        LEFT JOIN DB_GENERAL.TBL_CREDENCIAL C ON P.PE_CODIGO = C.CR_EM_CODIGO
        WHERE C.CR_NOMBRE_USUARIO = V_USER
        AND C.CR_PASSWORD = V_PASS
        AND C.CR_ESTATUS = 'ACTIVO';

        IF V_CANTIDAD = 1 THEN
            SET V_CODIGO = 0;
            SET V_RESULTADO = 'CONSULTA EXITOSA';

            -- RETORNAR DATOS SI LA VALIDACIÓN PASA
            SELECT
                P.PE_CODIGO AS ID_US,
                CONCAT(
                    TRIM(CONCAT(
                        IFNULL(P.PE_NOMBRE, ''), ' ',
                        IFNULL(P.PE_SEG_NOMBRE, ''), ' ',
                        IFNULL(P.PE_APELLIDO, ''), ' ',
                        IFNULL(P.PE_SEG_APELLIDO, '')
                    ))
                ) AS NOMBRE,
                C.CR_PERFIL AS P_US,
                C.CR_TIPO_USUARIO AS T_US,
                C.CR_TIPO_CLIENTE AS T_CL
            FROM DB_GENERAL.TBL_PERMISOS P
            LEFT JOIN DB_GENERAL.TBL_CREDENCIAL C ON P.PE_CODIGO = C.CR_EM_CODIGO
            WHERE C.CR_NOMBRE_USUARIO = V_USER
            AND C.CR_PASSWORD = V_PASS
            AND C.CR_ESTATUS = 'ACTIVO';

        ELSEIF V_CANTIDAD = 0 THEN
            SET V_CODIGO = 1;
            SET V_RESULTADO = 'USUARIO Y/O CONTRASEÑA INCORRECTOS';
        ELSE
            SET V_CODIGO = 2;
            SET V_RESULTADO = 'EXISTE MÁS DE UN USUARIO CON LAS MISMAS CREDENCIALES';
        END IF;

    END
    //

    DELIMITER ;