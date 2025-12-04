<?php

class GestorSession
{
    public function __construct()
    {
        session_start();
    }

    function statusSesion()
    {
        if (!isset($_SESSION['K_US'])) {
            $this->logout();
        }
    }

    function gestorSession()
    {
        if (isset($_SESSION['T_US'])) {
            echo $_SESSION['T_US'];
            exit;
            header("Location: /GestorBots/view/");
            exit();
        } else {
            $this->logout();
        }
    }

    function logout()
    {
        session_destroy();
        header("Location: /GestorBots/");
        exit();
    }
}
