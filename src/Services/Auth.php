<?php

namespace Carbe\App\Services;
use Carbe\App\Services\Flash;

class Auth {

    /**
     * Ouvre une session 
     * S'assure que l'utilisateur doit etre connecté pour accéder à certaines pages sinon
     * Effectue une redirection du visiteur sur la page de connexion/creation de compte
     */

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

    /**
     * Deconnecte l'utilisateur en supprimant la session
     * 
     */

    public static function offAuth() :void {

        unset($_SESSION['auth_user']);
    }

    }