<?php

namespace Carbe\App\Services;

 class Auth {

       public static function isAuth(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['auth_user'])) {
            $_SESSION['flash'] = "Connectez-vous pour accèder à cette page!";
            header('Location: /login');
            exit();
        }
    }

    public static function offAuth() :void {

        unset($_SESSION['auth_user']);
    }

    }