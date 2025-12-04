<?php

use Dom\Entity;

require '../../controller/store/Class.php';

class ConectionDb
{
    private $pdo;

    public function conectionDb()
    {
        try {
            $config = parse_ini_file('../../controller/store/store.ini');
        } catch (\Throwable $th) {
            echo 'Error: no string data found';
            exit();
        }

        try {
            $dsn = 'mysql:host=' . DeCrypt($config['store']) . ';dbname=' . DeCrypt($config['location']);
            $username = DeCrypt($config['arg1']);
            $password = DeCrypt($config['arg2']);
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8 COLLATE utf8_spanish_ci'
            ];

            $this->pdo = new PDO($dsn, $username, $password, $options);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("set names utf8");
            #echo 'Conexión exitosa a la base de datos';
            return $this->pdo;
        } catch (PDOException $e) {
            echo 'Falló la conexion: ' . $e->getMessage();
        }
    }

    public function cerrarConexion()
    {
        $this->pdo = null;
    }
}

#$conection = new conectionDb();
#$conection->conectionDb();

#ECHO '<BR>';
#ECHO 'EQ_DETALLE1 -> ' . EnCrypt("3.128.91.180");
#ECHO '<BR>';
#ECHO 'EQ_DETALLE1 -> ' . EnCrypt("GestorRpaPro");
#ECHO '<BR>';
#ECHO 'EQ_DETALLE1 -> ' . EnCrypt("RpaGestor2025.*");
#ECHO '<BR>';
#ECHO 'EQ_DETALLE1 -> ' . EnCrypt("db_general");
#ECHO '<BR>';