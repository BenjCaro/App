<?php 

namespace Carbe\App\Services;

class Flash {   

/**
* Stocke un message flash en session.
*
* @param string $message Le message à afficher
* @param string $type correspond à la classe css Bootstrap (ex: 'success', 'error', 'secondary')
*
* @return void
*/


    public static function set(string $message, string $type) :void  {

        if(!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
        $_SESSION['flash'][] = [
            "message" => $message,
            "type" => $type
        ];
    }

    public static function setErrorsForm(string $key, string $message, string $type = "secondary") :void {

        if(!isset($_SESSION['errors'][$key])) {
            $_SESSION['errors'][$key] = [];
        }

        $_SESSION['errors'][$key] = [
            "message" => $message, 
            "type" => $type
        ];
    }

/**
* Récupère et supprime le message flash stocké en session.
*
* @return array<int, array{ message: string, type: string}>

*/

    public static function get(): array  {
       
        if (!isset($_SESSION['flash'])) {
            return [];
        }

        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']); 
        return $flash;
    }


/**
* Récupère et supprime le ou les messages erreur dans la remplissage du formulaire.
*
* @return array{ message: string, type: string}
* @param string key correspond au champs du formulaire qui provoque l'erreur
*/

    public static function showErrorsForm($key) :array {
        if(!isset($_SESSION['errors'][$key])) {
            return [];
        }

        $errors = $_SESSION['errors'][$key];
        unset($_SESSION['errors'][$key]);
        return $errors;
    }

}