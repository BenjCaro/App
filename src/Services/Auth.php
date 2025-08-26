<?php

namespace Carbe\App\Services;
use Carbe\App\Services\Flash;

class Auth {

       public static function isAuth(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['auth_user'])) {
            
            Flash::set("Connectez-vous pour accèder à cette page!", "secondary");
            header('Location: /login');
            exit();
        }
    }

    public static function offAuth() :void {

        unset($_SESSION['auth_user']);
    }

    }