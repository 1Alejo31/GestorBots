DELIMITER //
CREATE OR REPLACE PROCEDURE DB_GENERAL.SAVE_USER_REGISTER(
    IN V_PRIMER_NOMBRE VARCHAR(200),
    IN V_SEGUNDO_NOMBRE VARCHAR(200),
    IN V_PRIMER_APELLIDO VARCHAR(200),
    IN V_SEGUNDO_APELLIDO VARCHAR(200),
    IN V_FECHA_NACIMIENTO DATE,
    IN V_TIPO_DOCUMENTO VARCHAR(200),
    IN V_DOCUMENTO VARCHAR(200),
    IN V_TELEFONO_MOVIL_U VARCHAR(50),
    IN V_EMAIL VARCHAR(200),
    IN V_PASSWORD VARCHAR(200),
    IN V_TIPO_USUARIO VARCHAR(200),
    IN V_TIPO_SERVICIO VARCHAR(200),
    IN V_NOMBRE_EMPRESA VARCHAR(200),
    IN V_NIT_EMPRESA VARCHAR(200),
    IN V_DIRECCION_EMPRESA VARCHAR(200),
    IN V_TELEFONO_MOVIL VARCHAR(200),
    IN V_URL_PAGINA VARCHAR(200),
    IN V_USUARIO_CREACION VARCHAR(200),
    OUT V_CODIGO INT,
    OUT V_RESULTADO VARCHAR(200)
)
BEGIN
    DECLARE V_CANTIDAD INT;
    DECLARE V_ID_INSERTADO INT;
    
    -- VALIDAR SI EL DOCUMENTO YA EXISTE
    SELECT COUNT(*) INTO V_CANTIDAD
    FROM DB_GENERAL.TBL_PERMISOS P
    WHERE P.PE_DOCUMENTO = V_DOCUMENTO;

    IF V_CANTIDAD > 0 THEN
        SET V_CODIGO = 1;
        SET V_RESULTADO = 'EL USUARIO CON ESE DOCUMENTO YA EXISTE';
    ELSE
        -- VALIDAR SI EL EMAIL YA EXISTE
        SELECT COUNT(*) INTO V_CANTIDAD
        FROM DB_GENERAL.TBL_PERMISOS P
        WHERE P.PE_CORREO = V_EMAIL;

        IF V_CANTIDAD > 0 THEN
            SET V_CODIGO = 1;
            SET V_RESULTADO = 'EL USUARIO CON ESE CORREO YA EXISTE';
        ELSE
            -- INSERTAR EN TBL_PERMISOS
            INSERT INTO DB_GENERAL.TBL_PERMISOS (
                PE_NOMBRE,
                PE_SEG_NOMBRE,
                PE_APELLIDO,
                PE_SEG_APELLIDO,
                PE_TIPO_DOCUMENTO,
                PE_DOCUMENTO,
                PE_CEL,
                PE_CORREO,
                PE_PERMISO,
                PE_FECHA_NACIMIENTO,
                PE_USUARIO_CREACION,
                PE_ESTATUS
            )
            VALUES (
                V_PRIMER_NOMBRE,
                V_SEGUNDO_NOMBRE,
                V_PRIMER_APELLIDO,
                V_SEGUNDO_APELLIDO,
                V_TIPO_DOCUMENTO,
                V_DOCUMENTO,
                V_TELEFONO_MOVIL_U,
                V_EMAIL,
                V_TIPO_USUARIO,
                V_FECHA_NACIMIENTO,
                V_USUARIO_CREACION,
                'ACTIVO'
            );

            SET V_ID_INSERTADO = LAST_INSERT_ID();

            -- INSERTAR EN TBL_CREDENCIAL
            INSERT INTO DB_GENERAL.TBL_CREDENCIAL (
                CR_EM_CODIGO,
                CR_NOMBRE_USUARIO,
                CR_PASSWORD,
                CR_PERFIL,
                CR_TIPO_USUARIO,
                CR_TIPO_CLIENTE,
                CR_QUIEN_CREACION,
                CR_ESTATUS
            )
            VALUES (
                V_ID_INSERTADO,
                V_EMAIL,
                V_DOCUMENTO,
                V_TIPO_USUARIO,
                V_TIPO_USUARIO,
                V_TIPO_SERVICIO,
                V_USUARIO_CREACION,
                'ACTIVO'
            );

            INSERT INTO DB_GENERAL.TBL_EMPRESA(
                EM_DETALLE,
                EM_DETALLE1,
                EM_DETALLE2,
                EM_DETALLE3,
                EM_DETALLE4,
                EM_DETALLE5,
                EM_USUARIO_CREACION,
                EM_ESTATUS
            )
            VALUES(
                V_ID_INSERTADO,
                V_NOMBRE_EMPRESA,
                V_NIT_EMPRESA,
                V_DIRECCION_EMPRESA,
                V_TELEFONO_MOVIL,
                V_URL_PAGINA,
                V_USUARIO_CREACION,
                'ACTIVO'
            );
            
            SET V_CODIGO = 0;
            SET V_RESULTADO = 'USUARIO REGISTRADO EXITOSAMENTE';
        END IF;
    END IF;
END
//

DELIMITER ;